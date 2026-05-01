const firebaseConfig = {
  apiKey: "YOUR_API_KEY",
  authDomain: "YOUR_PROJECT.firebaseapp.com",
  databaseURL: "YOUR_DB_URL",
  projectId: "YOUR_PROJECT"
};

firebase.initializeApp(firebaseConfig);
const db = firebase.database();

let mySymbol = null;
let myName = null;
let room = null;
let isMyTurn = false;

// CREATE BOARD
const boardDiv = document.getElementById("board");
for (let i = 0; i < 9; i++) {
  const d = document.createElement("div");
  d.className = "cell";
  d.onclick = () => cellClicked(i);
  boardDiv.appendChild(d);
}

// JOIN ROOM
function joinRoom() {
  room = document.getElementById("room-input").value.trim();
  myName = document.getElementById("name-input").value.trim();

  if (!room || !myName) {
    alert("Enter room and name");
    return;
  }

  const ref = db.ref("rooms/" + room);

  ref.on("value", (snap) => {
    const data = snap.val();

    if (!data && !mySymbol) {
      mySymbol = "X";
      ref.set({
        board: ["","","","","","","","",""],
        turn: "X",
        p1: myName,
        p2: null,
        score: {X:0,O:0,D:0},
        winner: null,
        line: [],
        chat: {}
      });
      return;
    }

    if (data && !data.p2 && !mySymbol) {
      mySymbol = "O";
      ref.update({ p2: myName });
    }

    if (mySymbol) {
      document.getElementById("join-screen").style.display = "none";
      document.getElementById("game-screen").style.display = "block";
    }

    updateUI(data);
    loadChat(data);
  });
}

// COPY LINK
function copyLink() {
  const roomVal = document.getElementById("room-input").value;
  const link = location.origin + location.pathname + "?room=" + roomVal;
  navigator.clipboard.writeText(link);
  alert("Link copied!");
}

// UPDATE UI
function updateUI(data) {
  if (!data || !data.board) return;

  const cells = document.querySelectorAll(".cell");

  cells.forEach(c => c.classList.remove("win"));

  data.board.forEach((val, i) => {
    if (cells[i]) cells[i].innerText = val;
  });

  if (data.line) {
    data.line.forEach(i => cells[i].classList.add("win"));
  }

  isMyTurn = data.turn === mySymbol && !data.winner;

  document.getElementById("player-status").innerText =
    `${data.p1} vs ${data.p2 || "Waiting"}`;

  document.getElementById("turn-display").innerText =
    data.winner ? "" : (isMyTurn ? "Your Turn" : "Waiting...");

  document.getElementById("p1-score").innerText =
    `${data.p1}: ${data.score?.X || 0}`;

  document.getElementById("p2-score").innerText =
    `${data.p2 || "Waiting"}: ${data.score?.O || 0}`;

  document.getElementById("draw-score").innerText =
    `Draw: ${data.score?.D || 0}`;

  if (data.winner) {
    document.getElementById("round-result").innerText =
      data.winner === "D" ? "Draw!" :
      `${data.winner === "X" ? data.p1 : data.p2} won`;

    setTimeout(restartRound, 2000);
  }
}

// CLICK
function cellClicked(i) {
  if (!isMyTurn) return;

  const ref = db.ref("rooms/" + room);

  ref.once("value", (snap) => {
    const data = snap.val();

    if (!data || data.board[i] !== "") return;

    data.board[i] = mySymbol;

    const result = checkWinner(data.board);

    let score = data.score || {X:0,O:0,D:0};

    if (result.w === "X") score.X++;
    else if (result.w === "O") score.O++;
    else if (result.w === "D") score.D++;

    ref.update({
      board: data.board,
      turn: mySymbol === "X" ? "O" : "X",
      winner: result.w,
      line: result.l,
      score: score
    });
  });
}

// RESTART
function restartRound() {
  db.ref("rooms/" + room).update({
    board: ["","","","","","","","",""],
    turn: "X",
    winner: null,
    line: []
  });
}

// WIN CHECK
function checkWinner(board) {
  const lines = [
    [0,1,2],[3,4,5],[6,7,8],
    [0,3,6],[1,4,7],[2,5,8],
    [0,4,8],[2,4,6]
  ];

  for (let l of lines) {
    const [a,b,c] = l;
    if (board[a] && board[a] === board[b] && board[a] === board[c]) {
      return {w: board[a], l};
    }
  }

  if (!board.includes("")) return {w:"D",l:[]};

  return {w:null,l:[]};
}

// CHAT
function sendMessage() {
  const input = document.getElementById("chat-input");
  const msg = input.value.trim();
  if (!msg) return;

  db.ref("rooms/"+room+"/chat").push({
    name: myName,
    text: msg
  });

  input.value = "";
}

function sendQuick(text) {
  db.ref("rooms/"+room+"/chat").push({
    name: myName,
    text: text
  });
}

function loadChat(data) {
  if (!data || !data.chat) return;

  const box = document.getElementById("chat-box");
  box.innerHTML = "";

  Object.values(data.chat).forEach(m => {
    const div = document.createElement("div");
    div.innerText = `${m.name}: ${m.text}`;
    box.appendChild(div);
  });
}

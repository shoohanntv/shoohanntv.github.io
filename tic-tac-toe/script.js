const firebaseConfig = {
  apiKey: "YOUR_API_KEY",
  authDomain: "YOUR_PROJECT.firebaseapp.com",
  databaseURL: "YOUR_DB_URL",
  projectId: "YOUR_PROJECT"
};

firebase.initializeApp(firebaseConfig);
const db = firebase.database();

let mySymbol, myName, room, isMyTurn=false;

// BOARD CREATE
const boardDiv = document.getElementById("board");
for(let i=0;i<9;i++){
  const d=document.createElement("div");
  d.className="cell";
  d.onclick=()=>cellClicked(i);
  boardDiv.appendChild(d);
}

// JOIN
function joinRoom(){
  room = room-input.value.trim();
  myName = name-input.value.trim();

  if(!room||!myName) return alert("Enter details");

  const ref = db.ref("rooms/"+room);

  ref.on("value",snap=>{
    const d=snap.val();

    if(!d&&!mySymbol){
      mySymbol="X";
      ref.set({
        board:["","","","","","","","",""],
        turn:"X",
        p1:myName,
        p2:null,
        score:{X:0,O:0,D:0},
        winner:null,
        line:[],
        chat:[]
      });
      return;
    }

    if(d&&!d.p2&&!mySymbol){
      mySymbol="O";
      ref.update({p2:myName});
    }

    if(mySymbol){
      join-screen.style.display="none";
      game-screen.style.display="block";
    }

    updateUI(d);
    loadChat(d);
  });
}

// COPY LINK
function copyLink(){
  const link=location.origin+location.pathname+"?room="+room-input.value;
  navigator.clipboard.writeText(link);
  alert("Copied!");
}

// UI
function updateUI(d){
  if(!d||!d.board) return;

  const cells=document.querySelectorAll(".cell");
  cells.forEach(c=>c.classList.remove("win"));

  d.board.forEach((v,i)=>cells[i].innerText=v);

  if(d.line) d.line.forEach(i=>cells[i].classList.add("win"));

  isMyTurn=d.turn===mySymbol&&!d.winner;

  player-status.innerText=`${d.p1} vs ${d.p2||"Waiting"}`;
  turn-display.innerText=isMyTurn?"Your Turn":"Waiting";

  p1-score.innerText=`${d.p1}: ${d.score.X}`;
  p2-score.innerText=`${d.p2||"Waiting"}: ${d.score.O}`;
  draw-score.innerText=`Draw: ${d.score.D}`;

  if(d.winner){
    winSound.play();
    round-result.innerText=
      d.winner==="D"?"Draw!":
      `${d.winner==="X"?d.p1:d.p2} won`;

    setTimeout(restartRound,2000);
  }
}

// CLICK
function cellClicked(i){
  if(!isMyTurn) return;
  clickSound.play();

  const ref=db.ref("rooms/"+room);

  ref.once("value",snap=>{
    const d=snap.val();
    if(d.board[i]!=="") return;

    d.board[i]=mySymbol;
    const r=check(d.board);

    let s=d.score;
    if(r.w==="X")s.X++;
    else if(r.w==="O")s.O++;
    else if(r.w==="D")s.D++;

    ref.update({
      board:d.board,
      turn:mySymbol==="X"?"O":"X",
      winner:r.w,
      line:r.l,
      score:s
    });
  });
}

// RESTART
function restartRound(){
  db.ref("rooms/"+room).update({
    board:["","","","","","","","",""],
    turn:"X",
    winner:null,
    line:[]
  });
}

// WIN CHECK
function check(b){
  const w=[[0,1,2],[3,4,5],[6,7,8],[0,3,6],[1,4,7],[2,5,8],[0,4,8],[2,4,6]];
  for(let l of w){
    const[a,b1,c]=l;
    if(b[a]&&b[a]===b[b1]&&b[a]===b[c]) return {w:b[a],l};
  }
  if(!b.includes("")) return {w:"D",l:[]};
  return {w:null,l:[]};
}

// CHAT
function sendMessage(){
  const msg=chat-input.value.trim();
  if(!msg)return;

  db.ref("rooms/"+room+"/chat").push({name:myName,text:msg});
  chat-input.value="";
}

function sendQuick(t){
  db.ref("rooms/"+room+"/chat").push({name:myName,text:t});
}

function loadChat(d){
  if(!d.chat)return;

  chat-box.innerHTML="";
  Object.values(d.chat).forEach(m=>{
    const div=document.createElement("div");
    div.innerText=`${m.name}: ${m.text}`;
    chat-box.appendChild(div);
  });
}

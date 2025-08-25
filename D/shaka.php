<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shaka Player - MPD Streaming</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/shaka-player/4.3.6/shaka-player.compiled.min.js"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #111;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
            flex-direction: column;
        }
        video {
            width: 80%;
            max-width: 800px;
            height: auto;
            border: 2px solid white;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <h2>Shaka Player - MPD Streaming</h2>
    <video id="video" controls autoplay></video>

    <script>
        // List of MPD files and keys mapped by ID
        const mpdFiles = {
            "ziggo3": {

                url: "https://mag02.tvx.prd.tv.odido.nl/wh7f454c46tw407556707_-381738111/PLTV/86/224/3221241511/3221241511.mpd?accountinfo=~~V2.0~yVi0dMX4icO5Ka9e92EQfg8812e1c1044f7d357066472e3ee99ef4~2dRB9E-vDtoAbYl169LbcJpxUgWVJtbeU_PlhGfNUflphvljOb5VaEhxruETYG9qcccaf5c5b655bf7504ed7ec5a1dd798f:UTC,",

                k1: "4dbea4b5713a4aa1ae3a2544cd522fc7",

                k2: "a8323ea99b2d6200a48e1bc27322d548"

            },
          
          "SSC3": {

                url: "https://ssc-3-enc.edgenextcdn.net/out/v1/42e86125555242aaa2a12056832e7814/index.mpd",

                k1: "7de5dd08ad8041d586c2f16ccc9490a1",

                k2: "5e1503f3398b34f5099933fedab847ef"

            },
          
           "FuboTV": {

                url: "https://abm5x5xaaaaaaaamjgudev5k44qb3.otte.live.cf.ww.aiv-cdn.net/pdx-nitro/live/clients/dash/enc/3b7qwiqzk3/out/v1/9f14895badca43e6a716db021dcd0c31/cenc.mpd",

                k1: "dc69b6159a0f9f0a4e03b3ff91cbacd5",

                k2: "d0dcbcd7723bc40df0bf34c9c092d51f"

            },
          
          "test5": {

                url: "https://d1zqtf09wb8nt5.cloudfront.net/livedash/oil/freetv/live/sport_5_gold/live.livx?indexMode&amp;dvr=7200000",

                k1: "f39088bc37945261b7570ac185a95536",

                k2: "dbbd601df4236ea0f55e60d99dd70564"

            },
          
          "SKYLIGAMX": {

                url: "https://aka-live1-ott.izzigo.tv/2/out/u/dash/SKY-SPORTS-16-HD/default.mpd",

                k1: "c88dc6c668cac3b468d4a4c7e176ff3d",

                k2: "1aeb739de2c14ed0ad658ca8043208d8"

            },

            "ziggo5": {

                url: "https://mag04.tvx.prd.tv.odido.nl/wh7f454c46tw865586829_-819821292/PLTV/86/224/3221241610/3221241610.mpd?accountinfo=~~V2.0~LNS2PBO5tyhp5z1Pe6ObBA6cd7a4ec35c4492167b9376e6dff2932~BZw2dESHw-I1PQCFh9gGxCMvrIIzgMdYAe900qj8l6aoXUX9ahyR6I9EUIu7nDR4f4887615c83ea7a8cee6dd33137c4ebe:UTC,",

                k1: "3fb40d85724942f994d86943f48021db",

                k2: "a6da8742502c8a2153067f5f2a70fb02"

            },

            "ziggo6": {

                url: "https://mag03.tvx.prd.tv.odido.nl/wh7f454c46tw1024019879_757686866/PLTV/86/224/3221241521/3221241521.mpd?accountinfo=~~V2.0~URnD_afuosWHfY5OEqRXOwfa01c8ac56cf4511de39c2c4a3cab278~iVxKjbtf2gx_dYFqI-vt5C4Cu3COYDjZaw6C_kO2T2wm30fwo1ctD1gr_e2PrgTh48867c3177f3c34842031623cb2e06c9:UTC,",

                k1: "1a0ffa532aa2498490826e2f6a37f7c9",

                k2: "a8cec27bc7d47909c5b0d8f473b43e8d"

            },
          
          "BEIN2AUS": {

                url: "https://a36aivottlinear-a.akamaihd.net/OTTB/syd-nitro/live/clients/dash/enc/6fbnr3ei4b/out/v1/57d2ae96a4cc4230881cd801b389edf6/cenc.mpd",

                k1: "9afd72f20573001c23672d2158892a5f",

                k2: "9bc32df48a2efac30072b7e5c683bcd1"

            },
          
          "SSC_EXTRA1": {

                url: "https://ssc-extra1-ak.akamaized.net/out/v1/647c58693f1d46af92bd7e69f17912cb/index.mpd",

                k1: "ecbc9e6fe6b145efb6658fb5cf7427f8",

                k2: "03c17e28911f71221acbc0b11f900401"

            },
          
          "ClubRTL": {

                url: "https://live-video.dpgmedia.net/f1d26a28c95485cc/out/v1/6810477d8b1b4e458506df3803486870/index.mpd",

                k1: "a23c541ad1334ea697bab962336d31e6",

                k2: "996515f9b655011b20993c5514298eb3"

            },
          
          "SETANTA": {

                url: "https://cdnlb.tvplayhome.lt/live/eds/Setanta_LT_HD/GO3_LIVE_DASH/Setanta_LT_HD.mpd",

                k1: "f283293f48534648b74ddeda0cd283dd",

                k2: "baaa81b9144162d81da11d4a7e302017"

            },
          
          "Go3sp1": {

                url: "https://tr.live.cdn.cgates.lt/live/dash/560502/index.mpd",

                k1: "f48a8131e05f4d6e84de19f086c781a6",

                k2: "fd28f2f966a906f4d4dcfd72ae90094e"

            },
          
          "Go3sp2": {

                url: "https://tr.live.cdn.cgates.lt/live/dash/560505/index.mpd",

                k1: "8315b1996d92477b965cb29100a3dc07",

                k2: "0081c0674e9047e219caa27a07da9d4b"

            },
          
          "Hindi": {

                url: "https://a170aivottlinear-a.akamaihd.net/OTTB/sin-nitro/live/clients/dash/enc/1jii7mxinw/out/v1/fe9782633a364a6a84c9410f26d9b2c4/cenc.mpd",

                k1: "553a8e7efc48840b17d03797c023d9b6",

                k2: "05fa313fa73df33f19e0f2d3d047bbaf"

            },
          
          "English": {

                url: "https://ablayc7aaaaaaaamjadq6qgmrvpao.otte.live.cf.ww.aiv-cdn.net/pdx-nitro/live/clients/dash/enc/knd7y1u4mu/out/v1/e6aaa1b986d0434b95156e22db44eb71/cenc.mpd",

                k1: "9cb6b6283487afe392adcffebf3cd6be",

                k2: "05f4eb67381e0c173954603518ce84c3"

            },
          
          "DAZNLALIGA": {

                url: "https://ottb.live.cf.ww.aiv-cdn.net/dub-nitro/live/clients/dash/enc/yasjqprt7n/out/v1/8086df78d3ce479e8e375147f72942c6/cenc.mpd",

                k1: "43d1c3b25207ff38b22ccfe17d302367",

                k2: "7b1f85f6e81059473b114c16a25c829a"

            },
          
          "ziggo2": {

                url: "https://mag03.tvx.prd.tv.odido.nl/wh7f454c46tw266117884_-1972819316/PLTV/86/224/3221241560/3221241560.mpd?accountinfo=~~V2.0~OhA1DF4svOZppKxb-t-Ngw144cce44121c63284a33d5453493e5c8~1_Fmlu5PevHMYnEi9Z_HX2goKAd0VHSuxZMoIcAXcawYvG1meqGp2eQ2Ibhjvh7e59e7f6df3d57f23a32024ad67f0f19dc:UTC,",

                k1: "3cfa8625f650406ebf6a4d1ea737f572",

                k2: "0534e747c70b364aa7210e1bf3191df0"

            },
          
            "ch1": {
                url: "https://www.oha.to/play/3064015582/index.m3u8",
            },
          
            "ch2": {
                url: "https://cloudserve.world/live/stream_2.m3u8",
            },
            "ch3": {
                url: "https://cloudserve.world/live/stream_3.m3u8",
            },
            "ch4": {
                url: "https://cloudserve.world/live/stream_4.m3u8",
            },
            "ch5": {
                url: "https://cloudserve.world/live/stream_5.m3u8",
            },
            "ch6": {
                url: "https://cloudserve.world/live/stream_6.m3u8",
            },
            "ch7": {
                url: "https://cloudserve.world/live/stream_7.m3u8",
            },
            "ch8": {
                url: "https://cloudserve.world/live/stream_8.m3u8",
            },
            "ch9": {
                url: "https://cloudserve.world/live/stream_9.m3u8",
            },
            "ch10": {
                url: "https://cloudserve.world/live/stream_10.m3u8",
            },
            "ch11": {
                url: "https://cloudserve.world/live/stream_11.m3u8",
            },
            "ch12": {
                url: "https://cloudserve.world/live/stream_12.m3u8",
            },
            "ch13": {
                url: "https://cloudserve.world/live/stream_13.m3u8",
            },
            "ch14": {
                url: "https://cloudserve.world/live/stream_14.m3u8",
            },
            "ch15": {
                url: "https://cloudserve.world/live/stream_15.m3u8",
            },
            "ch16": {
                url: "https://cloudserve.world/live/stream_16.m3u8",
            },
            "ch17": {
                url: "https://cloudserve.world/live/stream_17.m3u8",
            },
            "ch18": {
                url: "https://cloudserve.world/live/stream_18.m3u8",
            },
            "ch19": {
                url: "https://cloudserve.world/live/stream_19.m3u8",
            },
            "ch20": {
                url: "https://cloudserve.world/live/stream_20.m3u8",
            },
            "pl1": {
                url: "https://cloudserve.world/live/stream_pl1.m3u8",
            },
            "ep2": {
                url: "https://cloudserve.world/live/stream_ep2.m3u8",
            },
            "ep3": {
                url: "https://allfreeshoping.online/live/stream_ep3.m3u8",
            },
            "ep4": {
                url: "https://allfreeshoping.online/live/stream_ep4.m3u8",
            },
            "ep5": {
                url: "https://cloudserve.world/live/stream_ep5.m3u8",
            },
            "pl6": {
                url: "https://cloudserve.world/live/stream_pl6.m3u8",
            },
            "pl7": {
                url: "https://cloudserve.world/live/stream_pl7.m3u8",
            },
            "pl8": {
                url: "https://cloudserve.world/live/stream_pl8.m3u8",
            },
            "pl9": {
                url: "https://cloudserve.world/live/stream_pl9.m3u8",
            },
          
          "Eleven_1_Poland": {

                url: "https://n-25-31.dcs.redcdn.pl/livedash/o2/tvnplayerncp/live/11/live.isml/playlist.mpd?indexMode=&dummyfile=&server_side_events=0&dvr=7200000",

                k1: "3bdddc3ae3bb43b7a93d6ff72991e5dc",

                k2: "9a1ca978d3bb5fe1300696f9683567eb"

            },
          
          "ziggo6": {

                url: "https://mag03.tvx.prd.tv.odido.nl/wh7f454c46tw1024019879_757686866/PLTV/86/224/3221241521/3221241521.mpd?accountinfo=~~V2.0~URnD_afuosWHfY5OEqRXOwfa01c8ac56cf4511de39c2c4a3cab278~iVxKjbtf2gx_dYFqI-vt5C4Cu3COYDjZaw6C_kO2T2wm30fwo1ctD1gr_e2PrgTh48867c3177f3c34842031623cb2e06c9:UTC,",

                k1: "1a0ffa532aa2498490826e2f6a37f7c9",

                k2: "a8cec27bc7d47909c5b0d8f473b43e8d"

            },
          
          "USA_NET": {

                url: "https://fsly.stream.peacocktv.com/Content/CMAF_OL1-CTR-4s/Live/channel(usa-east)/master.mpd",

                k1: "78ab64fa90f137a697743b5dc27b2f96",

                k2: "de4d31c7fc6005ede28abab2a0720a9f"

           },
          
          "willo": {

                url: "https://cors-anywhere.ammoapps.com/https://dfwlive-v1-c1p3-sponsored.akamaized.net/Content/HLS.cps/Live/channel(WILLHD-3291.dfw.1080)/09.m3u8",

                k1: "59ed8dc9d4a48857ef8e5865919496cc",

                k2: "0d3680bd8b349deda8b7fdd1da71b7f8"

            },
          
         "GO3_SPORT3": {

                url: "https://cdnlb.tvplayhome.lt/live/eds/TV3_Sport3_HD_HVC/GO3_LIVE_DASH_AVC/TV3_Sport3_HD_HVC.mpd",

                k1: "a2a75672057f462089c2849b8184fcb0",

                k2: "94899cace4911c617c27d8f878de2b43"

           },

            "ZIGGO_SPORT": {

                url: "https://mag03.tvx.prd.tv.odido.nl/wh7f454c46tw75168188_-627298088/PLTV/86/224/3221241590/3221241590.mpd?zoneoffset=0&devkbps=1-7000&servicetype=1&icpid=86&accounttype=1&limitflux=-1&limitdur=-1&tenantId=3103&accountinfo=%7E%7EV2.0%7EqbcsJh_jU5C9BcZc959e_wae44b4867b3417aa76b5db2da20fe46c%7EKZzTWjB8qD1zdgbJjRPVLJX-tV0qiN9RBHC_iseGrsmTSRjj06oGDtGlpSCRGOwF3626cf085c08d024c7e4aafc18c32440%7EExtInfo5Ro3VppWiUusj2ippqUPkQ%3D%3D4a2d2c8ce133f43026d0e31b822b8474%3A20240601012829%3AUTC%2C10001003329222%2C87.212.140.171%2C20240601012829%2C3103_SP1S%2C10001003329222%2C-1%2C0%2C1%2C%2C%2C2%2C3103_Sport1%2C%2C%2C2%2C10000044444303%2C0%2C10000025050255%2CNDEzODg2NTY3MzEwMzI2NzMwNjMwNTY%3D%2C%2C%2C5%2C1%2CEND&GuardEncType=2&RTS=1717205309&from=11&hms_devid=1008&online=1717205309&mag_hms=1008,311,305&_=1717205322621",

                k1: "ef34ae91b4f2415e8439b2ad105e7488",

                k2: "243248d8de1ff8c7c587ee2057317523"

            },
          
          "match2": {

                url: "https://video.beeline.tv/live/d/channel320.isml/manifest-stb.mpd",

                k1: "ce7cf9b28d1a8d874accebc44d7e1fcd",

                k2: "cda18d4d20abd5cc778315abe277feb9"

            },
          
          "SSC1": {

                url: "https://ssc-1-enc.edgenextcdn.net/out/v1/c696e4819b55414388a1a487e8a45ca1/index.mpd",

                k1: "d84c325f36814f39bbe59080272b10c3",

                k2: "550727de4c96ef1ecff874905493580f"

            },

            "SSC2": {

                url: "https://ssc-2-enc.edgenextcdn.net/out/v1/a16db2ec338a445a82d9c541cc9293f9/index.mpd",

                k1: "8BCFC55359E24BD7AD1C5560A96DDD3C",

                k2: "b5dcf721ab522af92a9d3bf0bd55b596"

            },

            "SSC3": {

                url: "https://ssc-3-enc.edgenextcdn.net/out/v1/42e86125555242aaa2a12056832e7814/index.mpd",

                k1: "7de5dd08ad8041d586c2f16ccc9490a1",

                k2: "5e1503f3398b34f5099933fedab847ef"

            },

            "SSC4": {

                url: "https://ssc-4-enc.edgenextcdn.net/out/v1/5267ea5772874b0db24559d643eaad93/index.mpd",

                k1: "5c672f6b85a94638872d0214f7806ed4",

                k2: "bf8756fbb866ee2d5c701c2289dd8de3"

            },

            "SSC5": {

                url: "https://ssc-5-enc.edgenextcdn.net/out/v1/99289eac5a7b4319905da595afbd792b/index.mpd",

                k1: "c88b512b17ab4f6cb09eb0ff4a1056ed",

                k2: "adc08ee1c20a734972a55c9aebbd1888"

            },

            "SSC_EXTRA1": {

                url: "https://ssc-extra-1-enc.edgenextcdn.net/out/v1/647c58693f1d46af92bd7e69f17912cb/index.mpd",

                k1: "ecbc9e6fe6b145efb6658fb5cf7427f8",

                k2: "03c17e28911f71221acbc0b11f900401"

            },

            "SSC_EXTRA2": {

                url: "https://ssc-extra2-ak.akamaized.net/out/v1/8b70de2b70d447ba8a7450ba90926a2d/index.mpd",

                k1: "4d89249bd4ca4ebc9e70443265f9507d",

                k2: "cf074ffd2646c9c2f8513b47fa57bc30"

            },

            "SSC_EXTRA3": {

                url: "https://ssc-extra3-ak.akamaized.net/out/v1/8f1c6c3f05ef4284a64b342891bd85ae/index.mpd",

                k1: "98cfd6fd4812497fb24dc75f7545f2ee",

                k2: "d3006ee69e77b25939728ebf30d3180a"
              
              },
          
          "match3": {

                url: "https://video.beeline.tv/live/d/channel321.isml/manifest-stb.mpd",

                k1: "6cfb55b12aaa9df1626a8adaa4f26329",

                k2: "84486e2e8e5fdee2ef8240019923078c"

            },
          
           "match4": {

                url: "https://m7huvideolive.solocoo.tv/blueskylive2dash/bluedigisport1hu/Manifest.mpd",

                k1: "36d6377bb94b43a58af1c415ac686f4b",

                k2: "82fcba8160b4f88948cd3268bb330dbf"

            },
          
          
          
          "TNT_1_GB": {

                url: "https://ottb.live.cf.ww.aiv-cdn.net/lhr-nitro/live/clients/dash/enc/wf8usag51e/out/v1/bd3b0c314fff4bb1ab4693358f3cd2d3/cenc.mpd",

                k1: "ae26845bd33038a9c0774a0981007294",

                k2: "63ac662dde310cfb4cc6f9b43b34196d"

            },
          
  

            "TNT_2_GB": {

                url: "https://ottb.live.cf.ww.aiv-cdn.net/lhr-nitro/live/clients/dash/enc/f0qvkrra8j/out/v1/f8fa17f087564f51aa4d5c700be43ec4/cenc.mpd",

                k1: "6d1708b185c6c4d7b37600520c7cc93c",

                k2: "1aace05f58d8edef9697fd52cb09f441"

            },

            "TNT_3_GB": {

                url: "https://ottb.live.cf.ww.aiv-cdn.net/lhr-nitro/live/clients/dash/enc/lsdasbvglv/out/v1/bb548a3626cd4708afbb94a58d71dce9/cenc.mpd",

                k1: "4e993aa8c1f295f8b94e8e9e6f6d0bfe",

                k2: "86a1ed6e96caab8eb1009fe530d2cf4f"

            },

            "TNT_4_GB": {

                url: "https://ottb.live.cf.ww.aiv-cdn.net/lhr-nitro/live/clients/dash/enc/i2pcjr4pe5/out/v1/912e9db56d75403b8a9ac0a719110f36/cenc.mpd",

                k1: "e31a5a81caff5d07ea2411a571fc2e59",

                k2: "96c5ef69479732ae734f962748c19729"
              },
          
            "TNT_5_GB": {

                url: "https://ottb.live.cf.ww.aiv-cdn.net/lhr-nitro/live/clients/dash/enc/gesdwrdncn/out/v1/79e752f1eccd4e18b6a8904a0bc01f2d/cenc.mpd",

                k1: "60c0d9b41475e01db4ffb91ed557fbcc",

                k2: "36ee40e58948ca15e3caba8d47b8f34b"

              },
          
          "SSC_EXTRA1": {

                url: "https://ssc-extra1-ak.akamaized.net/out/v1/647c58693f1d46af92bd7e69f17912cb/index.mpd",

                k1: "ecbc9e6fe6b145efb6658fb5cf7427f8",

                k2: "03c17e28911f71221acbc0b11f900401"

            },

         "arenasports1p": {

                url: "https://webtvstream.bhtelecom.ba/hls7/as_premium1.mpd?n=himshim",

                k1: "c18b6aa739be4c0b774605fcfb5d6b68",

                k2: "e41c3a6f7532b2e3a828d9580124c89d"

            },

            "arenasports2p": {

                url: "https://webtvstream.bhtelecom.ba/hls7/as_premium2.mpd?n=himshim",

                k1: "c18b6aa739be4c0b774605fcfb5d6b68",

                k2: "e41c3a6f7532b2e3a828d9580124c89d"

            },

            "arenasports3p": {

                url: "https://webtvstream.bhtelecom.ba/hls6/as_premium3.mpd?n=himshim",

                k1: "c18b6aa739be4c0b774605fcfb5d6b68",

                k2: "e41c3a6f7532b2e3a828d9580124c89d"

            },

            "arenasports1": {

                url: "https://webtvstream.bhtelecom.ba/hls6/arena1.mpd?n=himshim",

                k1: "c18b6aa739be4c0b774605fcfb5d6b68",

                k2: "e41c3a6f7532b2e3a828d9580124c89d"

            },

            "arenasports2": {

                url: "https://webtvstream.bhtelecom.ba/hls6/arena2.mpd?n=himshim",

                k1: "c18b6aa739be4c0b774605fcfb5d6b68",

                k2: "e41c3a6f7532b2e3a828d9580124c89d"

            },

            "arenasports3": {

                url: "https://webtvstream.bhtelecom.ba/hls6/arena3.mpd?n=himshim",

                k1: "c18b6aa739be4c0b774605fcfb5d6b68",

                k2: "e41c3a6f7532b2e3a828d9580124c89d"

            },

            "arenasports4": {

                url: "https://webtvstream.bhtelecom.ba/hls6/arena4.mpd?n=himshim",

                k1: "c18b6aa739be4c0b774605fcfb5d6b68",

                k2: "e41c3a6f7532b2e3a828d9580124c89d"

            },

            "arenasports5": {

                url: "https://webtvstream.bhtelecom.ba/hls6/arena5.mpd?n=himshim",

                k1: "c18b6aa739be4c0b774605fcfb5d6b68",

                k2: "e41c3a6f7532b2e3a828d9580124c89d"

            },

            "arenasports6": {

                url: "https://webtvstream.bhtelecom.ba/hls6/arena6.mpd?n=himshim",

                k1: "c18b6aa739be4c0b774605fcfb5d6b68",

                k2: "e41c3a6f7532b2e3a828d9580124c89d"

            },
        };

        document.addEventListener('DOMContentLoaded', async () => {
            if (!shaka.Player.isBrowserSupported()) {
                alert("Error: Your browser doesn't support Shaka Player.");
                return;
            }

            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id'); // Get ID from URL parameter

            if (!id || !mpdFiles[id]) {
                alert("Error: Invalid or missing MPD ID.");
                return;
            }

            const video = document.getElementById('video');
            const player = new shaka.Player(video);

            // DRM Configuration (if needed)
            player.configure({
                drm: {
                    servers: {
                        'com.widevine.alpha': `https://drm-license-server.com/getkey?key=${mpdFiles[id].key}`
                    }
                }
            });

            player.load(mpdFiles[id].url).catch(error => {
                console.error('Error loading video:', error);
            });
        });
    </script>

</body>
</html>

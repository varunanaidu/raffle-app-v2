<!DOCTYPE html>
<html>
<head>
    <title>Raffle Control</title>
    <style>
        :root{
            --bg-red: #cc0000;
            --card-bg: rgba(235,117,115,0.9);
            --pill-white: #fff;
            --pill-red: #e31b23;
        }

        body {
            margin-top: 150px;
            background: var(--bg-red);
            min-height: 100vh;
            font-family: 'Segoe UI', 'Poppins', sans-serif;
            color: #fff;
            overflow-x: hidden;
            text-align: center;
        }

         .single {
            height: 500px;
            width: 500px;
            position: relative;
            background: linear-gradient(30deg, #0f0f0f 0%, #1a1a1a 50%, #2f2f2f 100%),
                radial-gradient(
                    circle,
                    #1a1a1a 0%,
                    #1a1a1a 40%,
                    #8c8c8c 42%,
                    #00000000 44%,
                    #00000000 100%
                );
            border-radius: 50%;
            border-top: 5px solid rgba(255, 255, 255, 0.3);
            border-bottom: 5px solid rgba(0, 0, 0, 1);
            box-shadow: -5px -5px 15px rgba(255, 255, 255, 0.1),
                5px 5px 15px rgba(0, 0, 0, 0.5);
            background-blend-mode: overlay;
            --accent-color: #3ac7f2;
            --shade-color: #0f2f87;
        }

        .single:after {
            --size: 200px;
            content: attr(data-label);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: bold;
            font-family: helvetica;
            color: rgba(255, 255, 255, 0.7);
            position: absolute;
            height: var(--size);
            width: var(--size);
            background: radial-gradient(
                circle at 65% 15%,
                white 1px,
                var(--accent-color) 3%,
                var(--shade-color) 60%,
                var(--accent-color) 100%
            );
            left: calc(50% - (var(--size) / 2));
            top: calc(50% - (var(--size) / 2));
            border-radius: 50%;
            border-top: 5px solid rgba(255, 255, 255, 0.3);
            border-bottom: 5px solid rgba(0, 0, 0, 1);
            transition: all 1s ease;
            cursor: pointer;
        }
        .single:hover:after {
            filter: hue-rotate(-100deg) brightness(150%);
        }

        .single:hover:before {
            filter: hue-rotate(-100deg) brightness(150%);
        }

        .single:active:after {
            filter: hue-rotate(140deg) brightness(80%);
            background: var(--accent-color);
            box-shadow: inset 10px 10px 10px rgba(0, 0, 0, 0.5),
                inset -10px -10px 10px rgba(255, 255, 255, 0.3);
        }
        .single:active:before {
            filter: hue-rotate(140deg) brightness(80%);
        }

        .single:before {
            content: "";
            position: absolute;
            width: 24px;
            height: 14px;
            background: radial-gradient(circle, #ffffff, #5cabff);
            border-radius: 5px 100% 100% 5px;
            top: -10px;
            left: calc(50% - 10px);
            box-shadow: 0 0 10px rgba(92, 171, 255, 0.8),
                -15px 0 8px rgba(92, 171, 255, 0.4), -25px 0 6px rgba(92, 171, 255, 0.2),
                -35px 0 4px rgba(92, 171, 255, 0.1);
            animation: orbit 5s linear infinite;
            transition: all 1s ease;
            transform-origin: 50% 250px;
        }

        @keyframes orbit {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        
    </style>
</head>
<body>

    <button id="controlBtn" class="single" data-label="START"></button>

    <script>
        const channel = new BroadcastChannel('raffle-control');
        const btn = document.getElementById('controlBtn');
        let isRunning = false;

        btn.addEventListener('click', () => {
            if (!isRunning) {
                channel.postMessage({ action: 'start' });
                console.log('Sent: start');
                btn.setAttribute('data-label', 'STOP');
                isRunning = true;
            } else {
                channel.postMessage({ action: 'stop' });
                console.log('Sent: stop');
                btn.setAttribute('data-label', 'START');
                isRunning = false;
            }
        });
    </script>
</body>
</html>

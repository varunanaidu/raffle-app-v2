<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🎁 Raffle for <?= esc($prizeName) ?></title>

    <!-- Fonts + Bootstrap (same as select-prize page) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root{
            --bg-red:rgb(255, 255, 255);
            --card-bg: rgba(235,117,115,0.9);
            --pill-white: #fff;
            --pill-red:rgb(0, 0, 0);
        }

        html,body { 
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        body {
            margin: 0;
            padding: 0;
            background: var(--bg-red) url('<?= base_url('images/doorprize.png') ?>') center center/cover no-repeat fixed;
            height: 100vh;
            width: 100vw;
            font-family: 'Segoe UI', 'Poppins', sans-serif;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
        }

        .corner-logo {
            position: fixed;
            z-index: 50;
            pointer-events: none;
        }

        .corner-logo.top-left {
            top: 20px;
            left: 20px;
        }

        .corner-logo.top-right {
            top: 20px;
            right: 20px;
        }

        .corner-logo.bottom-left {
            bottom: 20px;
            left: 20px;
        }

        .corner-logo.bottom-right {
            bottom: 20px;
            right: 20px;
        }

        .corner-logo img {
            max-width: 150px;
            height: auto;
        }

        .corner-logo.top-left img {
            width: 195.83px;
            height: 93.13px;
            max-width: none;
        }

        .corner-logo.top-right img {
            width: 145.35px;
            height: 94px;
            max-width: none;
        }

        .corner-logo.bottom-left {
            top: 520px;
            left: -26px;
            bottom: auto;
        }

        .corner-logo.bottom-left img {
            width: 70%;
            max-width: none;
            opacity: 1;
        }

        .corner-logo.bottom-right {
            top: 650px;
            left: 1130px;
            bottom: auto;
            right: auto;
            gap: 4.91px;
        }

        .corner-logo.bottom-right img {
            width: 421.599853515625px;
            height: 114.63893127441406px;
            max-width: none;
            opacity: 1;
        }

        @media (max-width: 768px) {
            .corner-logo img {
                max-width: 100px;
            }
            .corner-logo {
                top: 10px;
                right: 10px;
                left: 10px;
                bottom: 10px;
            }
        }

        .pilihan-hadiah-wrapper {
            margin-top: 20px;
            text-align: center;
            margin-bottom: 8px;
        }

        .pilihan-hadiah-pill {
          background: var(--pill-white);
          color: var(--pill-red);
          font-weight: 700;
          font-family: 'Poppins', sans-serif;
          padding: 2px 70px;
          border-radius: 999px;
          letter-spacing: 0.6px;
          font-size: 50px;
          display: inline-block;
          text-transform: uppercase;
          box-shadow: 0 2px 0 rgba(0,0,0,0.04) inset;
        }

        /* Prize layout adapted for raffle boxes */
        .raffle-stage {
            margin-top: 250px;
            display: flex;
            justify-content: center;
            gap: 24px;
            flex-wrap: wrap;
            padding: 18px;
            align-items: flex-start;
        }

        /* Each 'box' becomes a smaller prize-card look */
        .raffle-card {
            border-radius: 60px;
            padding: 18px;
            width: 400px;
            height: 120px;
            text-align: center;
            color: #111;
            position: relative;
            overflow: visible;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            backdrop-filter: blur(2px);
            cursor: default;
            transition: transform 0.12s ease, box-shadow 0.12s ease;
            border: 5px solid rgba(255,255,255,0.9);
            z-index: 100;
        }
        /* Alternating background colors: 1st=#ff9124, 2nd=black, 3rd=white, then loop */
        .raffle-card:nth-child(3n+1) {
            background: #ff9124;
        }
        .raffle-card:nth-child(3n+2) {
            background: #000000;
        }
        .raffle-card:nth-child(3n+3) {
            background:rgb(221, 213, 213);
        }
        .raffle-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.28);
        }

        .raffle-card .name-top {
            font-weight: 700;
            font-size: 40px;
            margin-bottom: -15px;
            color: #fff;
        }
        .raffle-card .company-top {
            font-size: 30px;
            color: white;
            margin-bottom: 8px;
        }
        /* Font colors for different card backgrounds */
        .raffle-card:nth-child(3n+1) .name-top, 
        .raffle-card:nth-child(3n+1) .name-item, 
        .raffle-card:nth-child(3n+1) .name-list,
        .raffle-card:nth-child(3n+1) .company-top {
            color: #000000;
        }
        .raffle-card:nth-child(3n+2) .name-top, 
        .raffle-card:nth-child(3n+2) .name-item, 
        .raffle-card:nth-child(3n+2) .name-list,
        .raffle-card:nth-child(3n+2) .company-top {
            color: #ff9124;
        }
        .raffle-card:nth-child(3n+3) .name-top, 
        .raffle-card:nth-child(3n+3) .name-item, 
        .raffle-card:nth-child(3n+3) .name-list,
        .raffle-card:nth-child(3n+3) .company-top {
            color: #000000;
        }

        /* Badge showing "X Pemenang" positioned top-center */
        .badge-winner-wrapper {
            position: absolute;
            top: 100px;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 999;
            pointer-events: none;
        }
        .badge-winner-pill {
            background: var(--pill-white);
            color: var(--pill-red);
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            padding: 6px 18px;
            border-radius: 999px;
            letter-spacing: 0.6px;
            font-size: 40px;
            display: inline-block;
            text-transform: uppercase;
            box-shadow: 0 2px 0 rgba(0,0,0,0.04) inset;
            line-height: 1;
            white-space: nowrap;
            border: 2px solid white;
        }

        .badge-winner-pill.large { padding: 10px 34px; font-size: 18px; }

        /* Message when already raffled */
        .raffled-message {
            color: #fff;
            font-weight: 700;
            padding: 40px 20px;
            text-align: center;
        }

        /* Scroll animation components */
        .scroll-container {
            height: 80px;
            overflow: hidden;
            position: relative;
            width: 100%;
        }
        .name-list {
            position: absolute;
            top: 100%;
            animation: scroll-up 5s linear infinite;
            width: 100%;
        }
        .name-item {
            height: 100px;
            line-height: 32px;
            text-align: center;
            font-size: 30px;
        }
        @keyframes scroll-up {
            0% { transform: translateY(0); }
            100% { transform: translateY(-50%); }
        }

        /* Shimmer animation style */
        .shimmer-box {
            position: relative;
            overflow: hidden;
            background: rgba(255,255,255,0.2);
            top: 40%;
            height: 30%;
            width: 100%;
            border-radius: 8px;
        }

        .shimmer-box::after {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            height: 100%;
            width: 100%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 1.6s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Confetti canvas overlay */
        canvas#confettiCanvas {
            position: fixed;
            top: 0;
            left: 0;
            pointer-events: none;
            width: 100%;
            height: 100%;
            z-index: 9999;
        }

        /* Responsive tweaks */
        @media (max-width: 480px) {
          .pilihan-hadiah-pill { padding: 6px 26px; font-size: 18px; }
          .badge-winner-pill { padding: 6px 18px; font-size: 13px; }
          .raffle-card { width: calc(100% - 40px); max-width: 360px; height: 120px; }
        }
    </style>
</head>
<body>

<!-- Corner Logos -->
<div class="corner-logo top-left">
    <img src="<?= base_url('images/maglogowhite.png') ?>" alt="Logo White">
</div>
<div class="corner-logo top-right">
    <img src="<?= base_url('images/maglogo.png') ?>" alt="Logo">
</div>
<div class="corner-logo bottom-left">
    <img src="<?= base_url('images/footerdoorprizesatu.png') ?>" alt="Footer">
</div>
<div class="corner-logo bottom-right">
    <img src="<?= base_url('images/footerdoorprizedua.png') ?>" alt="Footer">
</div>

<!-- Confetti canvas -->
<canvas id="confettiCanvas"></canvas>

<!-- Raffle stage (boxes) -->
<div class="raffle-stage" id="boxes"></div>

<!-- Audio -->
<audio id="winSound" src="https://www.fesliyanstudios.com/play-mp3/387" preload="auto"></audio>
<audio id="drumRollSound" src="https://cdn.pixabay.com/download/audio/2022/03/14/audio_6a8d318264.mp3?filename=drum-roll-6982.mp3" preload="auto" loop></audio>
<audio id="drumHitSound" src="https://cdn.pixabay.com/download/audio/2022/03/14/audio_4c70b30f26.mp3?filename=drum-hit-1-6984.mp3" preload="auto"></audio>

<!-- Confetti JS -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
    /* --- Data from server --- */
    const prizeId = <?= (int)$selectedPrizeId ?>;
    const stock = <?= (int)$selectedPrizeStock ?>;
    const names = <?= json_encode($names) ?>;
    let isRaffled = <?= $isRaffled ? 'true' : 'false' ?>; // made let so we can update after saving

    /* --- DOM elements --- */
    const boxes = document.getElementById('boxes');
    const winSound = document.getElementById('winSound');
    const drumRollSound = document.getElementById('drumRollSound');
    const drumHitSound = document.getElementById('drumHitSound');
    const confettiCanvas = document.getElementById('confettiCanvas');
    const myConfetti = confetti.create(confettiCanvas, { resize: true, useWorker: true });

    let remainingNames = [...names];
    let winners = [];

    // control flags
    let isRunning = false;
    let userCanControl = true; // when false, ignore spacebar actions

    function removeWinnersFromPool(winnerIds) {
      // Remove winners from remainingNames pool
      remainingNames = remainingNames.filter(nameStr => {
        const parts = nameStr.split('|');
        const id = parts[1];
        return !winnerIds.includes(id);
      });
    }

    /* Create visual boxes that match prize-card styling */
    function createBoxes() {
        boxes.innerHTML = '';

        // Badge
        const badgeWrapper = document.createElement('div');
        badgeWrapper.className = 'badge-winner-wrapper';
        const badge = document.createElement('div');
        badge.className = 'badge-winner-pill ' + (String(stock).length > 2 ? 'large' : '');
        badge.innerText = "<?= esc($prizeName, 'js') ?>";
        badgeWrapper.appendChild(badge);
        if (!document.querySelector('.badge-winner-wrapper')) {
            document.body.appendChild(badgeWrapper);
        }

        // Boxes
        for (let i = 0; i < stock; i++) {
            const card = document.createElement('div');
            card.className = 'raffle-card';
            card.innerHTML = `
                <div class="shimmer-box"></div>
                <div class="scroll-container d-none"></div>
            `;
            boxes.appendChild(card);
        }
    }

    function startRaffle() {
        if (remainingNames.length < stock) {
            alert("Not enough participants remaining.");
            return;
        }

        drumRollSound.currentTime = 0;
        drumRollSound.play();

        const shuffledPool = [...remainingNames];

        boxes.querySelectorAll('.raffle-card').forEach((card) => {
            // Remove shimmer
            const shimmer = card.querySelector('.shimmer-box');
            if (shimmer) shimmer.remove();

            const scrollContainer = card.querySelector('.scroll-container');
            scrollContainer.classList.remove('d-none');
            scrollContainer.innerHTML = '';

            const nameList = document.createElement('div');
            nameList.className = 'name-list';

            const shuffled = [...shuffledPool].sort(() => Math.random() - 0.5).slice(0, 30);
            for (let i = 0; i < 2; i++) {
                shuffled.forEach(n => {
                    const parts = n.split('|');
                    const name = parts[0] ?? '';
                    const company = parts[3] ?? '';
                    const item = document.createElement('div');
                    item.className = 'name-item';
                    item.innerText = `${name}`;
                    nameList.appendChild(item);
                });
            }

            scrollContainer.appendChild(nameList);
        });
    }

    function stopRaffle() 
    {
        // Stop drum roll immediately
        drumRollSound.pause();
        drumRollSound.currentTime = 0;

        // Play drum hit instantly
        drumHitSound.currentTime = 0;
        drumHitSound.play();

        winners = []; // reset in case
        boxes.querySelectorAll('.raffle-card').forEach((card) => {
            const rand = Math.floor(Math.random() * remainingNames.length);
            const raw = remainingNames.splice(rand, 1)[0];
            const [name, id, phone, company] = raw.split('|');

            // replace content with final winner display
            card.innerHTML = `
                <div class="name-top">${escapeHtml(name)}</div>
                <div class="company-top">${escapeHtml(company ?? '-')}</div>
            `;

            winners.push({ id, name, phone: phone ?? '-', company: company ?? '-' });
        });

        // audio + confetti right away
        try { winSound.currentTime = 0; winSound.play(); } catch(e){}
        myConfetti({ particleCount: 250, spread: 120, origin: { y: 0.6 } });

        // Save winners to server
        saveWinners();
    }


    function saveWinners() {
        fetch('/admin/save-winner-batch', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                prize_id: prizeId,
                winners: winners
            })
        }).then(res => res.json())
        .then(data => {
            if (!data.status || data.status !== 'success') {
                alert("Failed to save winners.");
            } else {
                // Remove saved winners from remainingNames pool
                const winnerIds = winners.map(w => w.id);
                removeWinnersFromPool(winnerIds);

                const done = document.createElement('div');
                done.className = 'raffled-message';
                done.innerHTML = `<strong>Winners saved successfully.</strong>`;
                document.body.appendChild(done);

                userCanControl = true;
                isRaffled = true;
            }
        }).catch(err => {
            console.error(err);
            alert("Failed to save winners (network error).");
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.code === 'Space') {
            e.preventDefault();

            if (isRaffled) {
                window.location.reload();
                return;
            }

            if (!isRunning) {
                isRunning = true;
                createBoxes();
                startRaffle();
            } else {
                isRunning = false;
                stopRaffle();
            }
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key.toLowerCase() === 'r') {
            if (!isRunning) {
                remainingNames = [...names];
                winners = [];
                const badge = document.querySelector('.badge-winner-wrapper');
                if (badge) badge.remove();
                createBoxes();
            }
        }
    });

    function escapeHtml(text) {
        if (!text && text !== 0) return '';
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    window.onload = () => {
        if (isRaffled) {
            boxes.innerHTML = `<div class="raffled-message"><strong>This prize has already been raffled.</strong></div>`;
            const existing = document.querySelector('.badge-winner-wrapper');
            if (!existing) {
                const badgeWrapper = document.createElement('div');
                badgeWrapper.className = 'badge-winner-wrapper';
                const badge = document.createElement('div');
                badge.className = 'badge-winner-pill ' + (String(stock).length > 2 ? 'large' : '');
                badge.innerText = "<?= esc($prizeName) ?>";
                badgeWrapper.appendChild(badge);
                document.body.appendChild(badgeWrapper);
            }
            setTimeout(() => {
                window.location.href = "<?= base_url('admin/select-prize') ?>";
            }, 1000);
        } else {
            createBoxes();
        }
    };

    /* --- 📡 Remote Control Listener (added) --- */
    const controlChannel = new BroadcastChannel('raffle-control');
    controlChannel.onmessage = (event) => {
        if (event.data.action === 'start' && !isRunning && !isRaffled) {
            isRunning = true;
            createBoxes();
            startRaffle();
        }
        if (event.data.action === 'stop' && isRunning) {
            isRunning = false;
            stopRaffle();
        }
    };
</script>


</body>
</html>

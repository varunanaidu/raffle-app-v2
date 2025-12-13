<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Grand Doorprize - <?= esc($prizeName) ?></title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

  <style>
    /* --- your existing styles --- */
    :root {
      --red: #e62125;
      --white: #ffffff;
      --muted: #222;
      --pill-font-size: 18px;
    }
    html, body {margin-top: -20px; font-family: 'Poppins', sans-serif; background: var(--white) url('<?= base_url('images/doorprize.png') ?>') center center/cover no-repeat fixed; color: var(--muted); overflow-x: hidden; }
    .page {position: relative; padding: 32px 48px; box-sizing: border-box; }
    .top { position: relative; display: flex; align-items: center; justify-content: center; }
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
    .doorprize-pill { background: var(--white); color: #ff9124; padding: 12px 46px; border-radius: 999px; font-weight: 600; font-size: 50px; letter-spacing: 0%; box-shadow: 0 10px 26px rgba(255, 255, 255, 0.12); z-index: 40; margin-top:100px; }
    .prize-wrapper { 
        margin-top: 50px;
        width: 600px;
        height: 400px;
        display: flex; 
        justify-content: center; 
        align-items: center; 
        flex-wrap: wrap; 
        background: #FFFFFF; 
        border-radius: 32px; 
        position: fixed; 
        top: 50%; 
        left: 50%; 
        transform: translate(-50%, -50%); 
        border: 14px solid #FFB738;
    }
    /* First inner white border */
    .prize-wrapper::before {
        content: "";
        position: absolute;
        inset: 14px;
        border-radius: 32px;
        background: #FFFFFF;
        box-shadow: 0 0 0 15px #FFFFFF inset;
        z-index: -1;
    }
    /* Second inner yellow border */
    .prize-wrapper::after {
        content: "";
        position: absolute;
        inset: 8px;
        border-radius: 32px;
        box-shadow: 0 0 0 5px #FFB738 inset;
        z-index: -1;
    }
    .prize-card {
        position: relative;
    }
    .prize-card img {
        width: auto;
        height: auto;
        max-width: 100%;
        object-fit: contain;
    }
    .badge-winner-wrapper {
        position: absolute;
        bottom: -45px;
        left: 50%;
        transform: translateX(-50%);
    }
    .badge-winner-pill {
        background: #FFFFFF;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 32px;
        padding: 12px 40px;
        border-radius: 50px;
        border: 6px solid #FFB738;
        box-shadow: 0 0 0 6px #FFFFFF inset;
        color: #000;
        white-space: nowrap;
    }
    .badge-winner-pill.large { padding: 10px 34px; font-size: 18px; }
    /* Raffle stage layout */
    .raffle-stage {
        display: none;
        justify-content: center;
        gap: 24px;
        margin-top: 150px;
        flex-wrap: wrap;
        padding: 18px;
        align-items: flex-start;
    }
    /* Each raffle-card */
    .raffle-card {
        border-radius: 100px;
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
    /* First card: #ff9124, Second card: rgb(221, 213, 213) */
    .raffle-card:nth-child(1) {
        background: #ff9124;
    }
    .raffle-card:nth-child(2) {
        background: rgb(221, 213, 213);
    }
    .raffle-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.28);
    }
    .raffle-card .name-top {
        font-weight: 700;
        font-size: 40px;
        margin-bottom: 4px;
        color: #000000;
    }
    .raffle-card .company-top {
        font-size: 30px;
        color: #000000;
        margin-bottom: 8px;
    }
    /* Font colors for different card backgrounds - all black */
    .raffle-card:nth-child(1) .name-top,
    .raffle-card:nth-child(1) .company-top {
        color: #000000;
    }
    .raffle-card:nth-child(2) .name-top,
    .raffle-card:nth-child(2) .company-top {
        color: #000000;
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
    /* Scroll animation components */
    .scroll-container {
        height: 182px;
        overflow: hidden;
        position: relative;
        width: 100%;
    }
    .scroll-container.d-none {
        display: none;
    }
    .name-list {
        position: absolute;
        top: 100%;
        animation: scroll-up 5s linear infinite;
        width: 100%;
        color: white;
    }
    .name-item {
        height: 100px;
        line-height: 32px;
        text-align: center;
        font-size: 30px;
        color: black;
    }
    @keyframes scroll-up {
        0% { transform: translateY(0); }
        100% { transform: translateY(-50%); }
    }
    .hide-with-animation { animation: slideFadeOut 0.5s ease forwards; }
    @keyframes slideFadeOut { 0% { opacity: 1; transform: translateX(0); } 100% { opacity: 0; transform: translateX(-100px); } }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
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

  <div class="page">
    <div class="top">
      <div class="doorprize-pill">GRANDPRIZE</div>
    </div>
    <div class="prize-wrapper" id="prize-container">
      <div class="prize-card">
        <div class="badge-winner-wrapper">
          <?php
            $winnerCount = 1;
            if (stripos($prizeName, 'iphone') !== false) {
                $winnerCount = 1;
            } elseif (stripos($prizeName, 'garmin') !== false) {
                $winnerCount = 2;
            } else {
                $winnerCount = $selectedPrizeStock;
            }
            $stockText = $winnerCount . ' Orang Pemenang';
            $isLarge = strlen((string)$winnerCount) > 2;
          ?>
          <div class="badge-winner-pill <?= $isLarge ? 'large' : '' ?>">
            <?= $stockText ?>
          </div>
        </div>
        <img src="<?= base_url('uploads/prizes/' . $selectedPrize['image']) ?>" alt="<?= esc($prizeName) ?>">
      </div>
    </div>
  </div>

  <div class="raffle-stage" id="winner-box"></div>

  <script>
    const prizeId = <?= (int)$selectedPrizeId ?>;
    const names = <?= json_encode($names ?? []) ?>;
    const stock = <?= (int)$selectedPrizeStock ?>;

    let raffleStage = 0;
    let winners = []; // Array to store winners, index matches card index
    let remainingNames = [...names];
    let intervalId = null;
    const winnerBox = document.getElementById('winner-box');
    const prizeContainer = document.getElementById('prize-container');

    const nextPrizeId = <?= json_encode($nextPrizeId) ?>;
    let winnerSaved = false;
    let isRaffling = false;
    let lockedCards = []; // Track which cards are locked (saved)

    function createRaffleCards() {
      winnerBox.innerHTML = '';
      lockedCards = [];
      winners = []; // Reset winners array
      for (let i = 0; i < stock; i++) {
        const card = document.createElement('div');
        card.className = 'raffle-card';
        card.dataset.cardIndex = i;
        card.innerHTML = `
          <div class="shimmer-box"></div>
          <div class="scroll-container d-none"></div>
        `;
        winnerBox.appendChild(card);
        lockedCards[i] = false; // Initialize as unlocked
        winners[i] = null; // Initialize winner slot
      }
    }

    function pickRandomName() {
      if (!remainingNames.length) return { name: 'No registrants', id: '', phone: '', company: '' };
      const raw = remainingNames[Math.floor(Math.random() * remainingNames.length)];
      const [name, id, phone, company] = raw.split('|');
      return { name, id, phone, company };
    }

    function startRaffling() {
      const shuffledPool = [...remainingNames];
      
      winnerBox.querySelectorAll('.raffle-card').forEach((card, index) => {
        // Skip locked cards
        if (lockedCards[index]) return;

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
            const item = document.createElement('div');
            item.className = 'name-item';
            item.innerText = `${name}`;
            nameList.appendChild(item);
          });
        }

        scrollContainer.appendChild(nameList);
      });
    }

    function stopRaffling() {
      winnerBox.querySelectorAll('.raffle-card').forEach((card, index) => {
        // Skip locked cards
        if (lockedCards[index]) return;

        const rand = Math.floor(Math.random() * remainingNames.length);
        const raw = remainingNames.splice(rand, 1)[0];
        const [name, id, phone, company] = raw.split('|');

        card.innerHTML = `
          <div class="name-top">${escapeHtml(name)}</div>
          <div class="company-top">${escapeHtml(company ?? '-')}</div>
        `;

        // Update winners array at correct index
        winners[index] = { id, name, phone: phone ?? '-', company: company ?? '-' };
        lockedCards[index] = true; // Lock this card
      });

      confetti({ particleCount: 250, spread: 120, origin: { y: 0.6 } });
      // Don't save here, will be saved when spacebar is pressed to stop
    }

    function removeWinnersFromPool(winnerIds) {
      // Remove winners from remainingNames pool
      remainingNames = remainingNames.filter(nameStr => {
        const parts = nameStr.split('|');
        const id = parts[1];
        return !winnerIds.includes(id);
      });
    }

    function reRaffleCard(cardIndex) {
      // cardIndex is 0-based, user presses 1, 2, etc.
      const index = cardIndex - 1;
      if (index < 0 || index >= stock || !lockedCards[index]) return;

      // Don't restore name to pool if it was already saved to database
      // (only restore if it was locked but not yet saved)
      const oldWinner = winners[index];
      // Note: We don't restore to pool because the name might already be in database
      // The name will be removed from database when we update winners

      // Unlock the card
      lockedCards[index] = false;
      winners[index] = null;

      // Reset card to initial state
      const card = winnerBox.querySelector(`.raffle-card[data-card-index="${index}"]`);
      if (card) {
        card.innerHTML = `
          <div class="shimmer-box"></div>
          <div class="scroll-container d-none"></div>
        `;
      }

      // If currently raffling, start raffling this card too
      if (isRaffling) {
        startRaffling();
      }
    }

    function saveWinners() {
      // Get only locked winners (those that have been saved)
      const validWinners = [];
      winners.forEach((w, index) => {
        if (w && w.id && lockedCards[index]) {
          validWinners.push(w);
        }
      });

      if (validWinners.length === 0) return;

      // Use update endpoint if already saved, otherwise use save endpoint
      const endpoint = winnerSaved 
        ? "<?= base_url('admin/update-winner-batch') ?>"
        : "<?= base_url('admin/save-winner-batch') ?>";
      
      fetch(endpoint, {
        method: "POST",
        headers: { 
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
          prize_id: prizeId,
          winners: validWinners
        })
      })
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success') {
          winnerSaved = true;
          // Remove saved winners from remainingNames pool
          const winnerIds = validWinners.map(w => w.id);
          removeWinnersFromPool(winnerIds);
        } else {
          alert('Error: ' + (res.message || 'Failed to save winners'));
        }
      })
      .catch(() => alert('Failed to save winners'));
    }

    function resetPage() {
      remainingNames = [...names];
      winners = [];
      isRaffling = false;
      winnerBox.style.display = 'flex';
      createRaffleCards();
      raffleStage = 1;
    }

    function escapeHtml(text) {
      if (!text && text !== 0) return '';
      return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    }

    document.addEventListener('keydown', (e) => {
      if (e.code === 'Space') {
        e.preventDefault();

        if (winnerSaved && nextPrizeId) {
          window.location.href = "<?= base_url('admin/grandprize/') ?>" + nextPrizeId;
          return;
        }

        if (raffleStage === 0) {
          prizeContainer.classList.add('hide-with-animation');
          setTimeout(() => {
            prizeContainer.style.display = 'none';
            winnerBox.style.display = 'flex';
            createRaffleCards();
          }, 500);
          raffleStage = 1;
        } else if (raffleStage === 1 || raffleStage === 3) {
          // Start raffling (toggle on)
          isRaffling = true;
          startRaffling();
          raffleStage = 2;
        } else if (raffleStage === 2) {
          // Stop raffling (toggle off)
          isRaffling = false;
          stopRaffling();
          raffleStage = 3;
          // Save winners after stopping (will update if already saved)
          saveWinners();
        }
      }

      // Number keys (1-9) to re-raffle specific cards
      if (e.key >= '1' && e.key <= '9') {
        const cardNum = parseInt(e.key);
        if (cardNum <= stock) {
          reRaffleCard(cardNum);
        }
      }

      if (e.key.toUpperCase() === 'R') resetPage();
    });
  </script>
</body>
</html>

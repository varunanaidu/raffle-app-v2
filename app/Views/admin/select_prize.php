<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🎁 Select Prize</title>

    <!-- Fonts + Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root{
            --bg-red:rgb(255, 255, 255);
            --card-bg: rgba(235,117,115,0.9);
            --pill-white: #fff;
            --pill-red: #e31b23;
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

        .header-banner {
            text-align: center;
            padding: 30px 10px 10px;
            color: white;
            font-size: 2rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .undian-info {
            position: absolute;
            top: 50px;
            right: 30px;
            text-align: right;
            font-size: 1rem;
            color: white;
            font-weight: 500;
        }

        .pilihan-hadiah-wrapper {
            margin-top: 60px;
            text-align: center;
            margin-bottom: 20px;
        }

        .pilihan-hadiah-pill {
          background: var(--pill-white);
          color: var(--pill-red);
          font-weight: 700;
          font-family: 'Poppins', sans-serif;
          padding: 2px 70px;
          border-radius: 999px;
          letter-spacing: 0.6px;
          font-size: 40px;
          display: inline-block;
          text-transform: uppercase;
          box-shadow: 0 2px 0 rgba(0,0,0,0.04) inset;
        }

        .prize-container {
            display: flex; 
            justify-content: center; 
            align-items: center; 
            flex-wrap: wrap; 
            gap: 20px; 
            background: #FFFFFF; 
            padding: 50px 55px 55px 55px; 
            border-radius: 32px; 
            position: fixed; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            border: 14px solid #FFB738;
        }

        /* First inner white border */
        .prize-container::before {
            content: "";
            position: absolute;
            inset: 14px;
            border-radius: 32px;
            background: #FFFFFF;
            box-shadow: 0 0 0 15px #FFFFFF inset;
            z-index: -1;
        }

        /* Second inner yellow border */
        .prize-container::after {
            content: "";
            position: absolute;
            inset: 8px;
            border-radius: 32px;
            box-shadow: 0 0 0 5px #FFB738 inset;
            z-index: -1;
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

    .selesai-ribbon {
        position: absolute;
        top: 45%;
        left: 50%;
        transform: translateX(-50%) rotate(-45deg);
        transform-origin: center;
        width: 150%;
        max-width: calc(100% + 160px);
        text-align: center;
        background: white;
        color: red;
        font-weight: 700;
        padding: 8px 0;
        font-size: 1rem;
        z-index: 1;
        border-radius: 6px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.25);
        pointer-events: none;
    }

    .prize-card.raffled img {
        filter: grayscale(100%);
        opacity: 0.7; /* optional */
    }

    /* Slight tweak for smaller screens so ribbon doesn't overwhelm */
    @media (max-width: 480px) {
        .selesai-ribbon {
            width: 160%;
            top: 20%;
            font-size: 0.95rem;
            padding: 6px 0;
        }
        .badge-finished {
            top: 10px;
            padding: 4px 12px;
            font-size: 0.85rem;
        }
    }


    @media (max-width: 480px) {
      .pilihan-hadiah-pill { padding: 6px 26px; font-size: 18px; }
      .badge-winner-pill { padding: 6px 18px; font-size: 13px; }
      .prize-card { width: calc(100% - 40px); max-width: 320px; }
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

<div class="prize-container" id="prizeContainer" role="grid" aria-label="Daftar hadiah">
    <?php foreach ($prizes as $i => $prize): ?>
        <?php
            $isRaffled = (!empty($prize['raffled']) && $prize['raffled'] == 1);
            $safeId = (int)$prize['id'];
        ?>
        <div 
            class="prize-card <?= $isRaffled ? 'raffled' : '' ?>"
            data-index="<?= $i ?>"
            data-prize-id="<?= $safeId ?>"
            data-raffled="<?= $isRaffled ? '1' : '0' ?>"
            style="cursor: <?= $isRaffled ? 'not-allowed' : 'pointer' ?>;"
            onclick="<?= $isRaffled ? 'return false;' : "handlePrizeClick(" . (int)$prize['id'] . ")" ?>"
        >
            <?php if ($isRaffled): ?>
                <div class="selesai-ribbon">Selesai &bull; Selesai &bull; Selesai &bull; Selesai &bull; Selesai</div>
            <?php else: ?>
                <div class="badge-winner-wrapper">
                    <?php
                        $stockText = esc($prize['stock']) . ' Orang Pemenang';
                        $isLarge = strlen((string)$prize['stock']) > 2;
                    ?>
                    <div class="badge-winner-pill <?= $isLarge ? 'large' : '' ?>">
                        <?= $stockText ?>
                    </div>
                </div>
            <?php endif; ?>
            <img src="<?= base_url('uploads/prizes/' . ($prize['image'] ?? '')) ?>" alt="<?= esc($prize['name']) ?>">
        </div>
    <?php endforeach; ?>
</div>

<script>
(function() {
    const container = document.getElementById('prizeContainer');
    const cards = Array.from(container.querySelectorAll('.prize-card'));

    // This controls how many prizes per page for each step
    const pageSizes = [3, 2, 3];
    let currentPage = 0;

    function showPage(pageIndex) {
        let start = 0;
        for (let i = 0; i < pageIndex; i++) {
            start += pageSizes[i] || 0;
        }
        const count = pageSizes[pageIndex] || 0;

        cards.forEach((card, idx) => {
            if (idx >= start && idx < start + count) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });

        // Save current page to localStorage
        localStorage.setItem('selectedPrizePage', pageIndex);
    }

    function nextPage() {
        if (currentPage < pageSizes.length - 1) {
            currentPage++;
            showPage(currentPage);
        }
    }

    function prevPage() {
        if (currentPage > 0) {
            currentPage--;
            showPage(currentPage);
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key.toLowerCase() === 'n') {
            nextPage();
        } else if (e.key.toLowerCase() === 'x') {
            prevPage();
        }
    });

    // Restore page index from localStorage if available
    const savedPage = parseInt(localStorage.getItem('selectedPrizePage'), 10);
    if (!isNaN(savedPage) && savedPage >= 0 && savedPage < pageSizes.length) {
        currentPage = savedPage;
    }

    // Initial display
    showPage(currentPage);
})();
</script>

<script>
/*
 Keyboard navigation behavior:
 - ArrowLeft / ArrowRight / ArrowUp / ArrowDown navigate among non-raffled cards
 - Enter selects (calls handlePrizeClick)
 - Home / End to jump to first/last selectable
 - Click still works and sets selection
 - Selection wraps within bounds but doesn't select raffled cards
*/

(function () {
    const container = document.getElementById('prizeContainer');
    let cards = Array.from(container.querySelectorAll('.prize-card'));

    function refreshSelectableList() {
        cards = Array.from(container.querySelectorAll('.prize-card'));
    }

    function selectableIndices() {
        const list = [];
        cards.forEach((c, i) => {
            if (c.dataset.raffled !== '1') list.push(i);
        });
        return list;
    }

    function getCols() {
        const first = cards[0];
        if (!first) return 1;
        const cardWidth = first.offsetWidth;
        const gap = parseInt(getComputedStyle(container).gap || '40', 10);
        const containerWidth = container.clientWidth;
        return Math.max(1, Math.floor((containerWidth + gap) / (cardWidth + gap)));
    }

    function indexOfCard(el) {
        return cards.indexOf(el);
    }

    function clearSelection() {
        cards.forEach(c => c.classList.remove('selected'));
    }

    function selectByIndex(idx) {
        if (idx < 0 || idx >= cards.length) return null;
        const el = cards[idx];
        if (!el || el.dataset.raffled === '1') return null;
        clearSelection();
        el.classList.add('selected');
        el.focus({preventScroll: true});
        el.scrollIntoView({block: 'nearest', inline: 'nearest', behavior: 'smooth'});
        return el;
    }

    function findNextSelectable(startIdx, step) {
        let idx = startIdx + step;
        const len = cards.length;
        while (idx >= 0 && idx < len) {
            if (cards[idx].dataset.raffled !== '1') return idx;
            idx += step;
        }
        return null;
    }

    function move(currentIdx, dir) {
        const cols = getCols();
        let targetIdx = null;
        if (dir === 'left') {
            targetIdx = findNextSelectable(currentIdx, -1);
        } else if (dir === 'right') {
            targetIdx = findNextSelectable(currentIdx, +1);
        } else if (dir === 'up') {
            targetIdx = findNextSelectable(currentIdx, -cols);
            if (targetIdx === null) {
                const rowStart = Math.floor(currentIdx / cols) * cols;
                for (let i = currentIdx - 1; i >= rowStart; i--) {
                    if (cards[i] && cards[i].dataset.raffled !== '1') { targetIdx = i; break; }
                }
            }
        } else if (dir === 'down') {
            targetIdx = findNextSelectable(currentIdx, +cols);
            if (targetIdx === null) {
                const rowEnd = Math.min(cards.length - 1, (Math.floor(currentIdx / cols) * cols) + (cols - 1));
                for (let i = currentIdx + 1; i <= rowEnd; i++) {
                    if (cards[i] && cards[i].dataset.raffled !== '1') { targetIdx = i; break; }
                }
            }
        }
        return targetIdx;
    }

    function initSelection() {
        refreshSelectableList();
        const selectable = selectableIndices();
        if (selectable.length) {
            selectByIndex(selectable[0]);
        }
    }

    container.addEventListener('click', (ev) => {
        const card = ev.target.closest('.prize-card');
        if (!card) return;
        if (card.dataset.raffled === '1') return;
        refreshSelectableList();
        const idx = indexOfCard(card);
        if (idx >= 0) selectByIndex(idx);
    });

    document.addEventListener('keydown', (ev) => {
        const key = ev.key;
        const active = document.activeElement;
        const activeTag = active && active.tagName ? active.tagName.toLowerCase() : null;
        if (activeTag === 'input' || activeTag === 'textarea' || active.isContentEditable) {
            return;
        }

        if (!['ArrowLeft','ArrowRight','ArrowUp','ArrowDown','Enter','Home','End',' '].includes(key)) return;

        ev.preventDefault();

        refreshSelectableList();
        let currentEl = container.querySelector('.prize-card.selected') || document.activeElement.closest?.('.prize-card') || null;
        let currentIdx = currentEl ? indexOfCard(currentEl) : -1;

        if (currentIdx === -1) {
            initSelection();
            return;
        }

        let targetIdx = null;
        if (key === 'ArrowLeft') {
            targetIdx = move(currentIdx, 'left');
        } else if (key === 'ArrowRight') {
            targetIdx = move(currentIdx, 'right');
        } else if (key === 'ArrowUp') {
            targetIdx = move(currentIdx, 'up');
        } else if (key === 'ArrowDown') {
            targetIdx = move(currentIdx, 'down');
        } else if (key === 'Home') {
            const list = selectableIndices();
            targetIdx = list.length ? list[0] : null;
        } else if (key === 'End') {
            const list = selectableIndices();
            targetIdx = list.length ? list[list.length - 1] : null;
        } else if (key === 'Enter' || key === ' ') {
            const el = cards[currentIdx];
            if (el && el.dataset.raffled !== '1') {
                const prizeId = el.dataset.prizeId;
                handlePrizeClick(prizeId);
            }
            return;
        }

        if (targetIdx !== null && targetIdx !== undefined) {
            selectByIndex(targetIdx);
        }
    });

    window.addEventListener('resize', () => {
        const current = container.querySelector('.prize-card.selected');
        if (current) current.scrollIntoView({block: 'nearest', inline: 'nearest', behavior: 'smooth'});
    });

    window.addEventListener('load', initSelection);
})();
</script>

<script>
function handlePrizeClick(prizeId) {
    if (window._isSubmitting) return;
    window._isSubmitting = true;

    // Save current page index before leaving
    const currentPage = localStorage.getItem('selectedPrizePage') || 0;
    localStorage.setItem('selectedPrizePage', currentPage);

    const body = `prize_id=${encodeURIComponent(prizeId)}`;
    fetch("<?= base_url('admin/savePrizeSelection') ?>", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: body
    })
    .then(async response => {
        if (response.ok) {
            window.location.href = "<?= base_url('admin/raffle') ?>";
            return;
        } else {
            let text = '';
            try { text = await response.text(); } catch(e){}
            window._isSubmitting = false;
            alert("Gagal menyimpan pilihan hadiah." + (text ? ("\n\n" + text) : ""));
        }
    })
    .catch(error => {
        console.error("Error:", error);
        window._isSubmitting = false;
        alert("Terjadi kesalahan saat menyimpan. Periksa koneksi Anda.");
    });
}
</script>

</body>
</html>

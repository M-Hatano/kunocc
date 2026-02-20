const calendarEl = document.getElementById('calendar');
const currentMonthEl = document.getElementById('current-month');

let today = new Date();
let viewYear = today.getFullYear();
let viewMonth = today.getMonth() + 1;

// ↓ 修正①: eventsMapをここ（グローバル）で一度だけ作成（ループ内から外す）
const eventsMap = {};
document.querySelectorAll('#calendar-events [data-date]').forEach(el => {
    eventsMap[el.dataset.date] = el.innerHTML;
});

// 「前へ」ボタン：今月より前には戻らせない
document.getElementById('prev').addEventListener('click', () => {
    let targetYear = viewYear;
    let targetMonth = viewMonth - 1;
    if (targetMonth < 1) {
        targetMonth = 12;
        targetYear--;
    }

    const minDate = new Date(today.getFullYear(), today.getMonth(), 1);
    const targetDate = new Date(targetYear, targetMonth - 1, 1);

    if (targetDate < minDate) return;

    viewYear = targetYear;
    viewMonth = targetMonth;
    updateCalendar();
});

// 「次へ」ボタン：今月を含めて5ヶ月分（今月 + 4ヶ月先）まで
document.getElementById('next').addEventListener('click', () => {
    let targetYear = viewYear;
    let targetMonth = viewMonth + 1;
    if (targetMonth > 12) {
        targetMonth = 1;
        targetYear++;
    }

    // ★制限の計算：今月から数えて5ヶ月後の1日（合計4ヶ月分）
    const maxDate = new Date(today.getFullYear(), today.getMonth() + 4, 1);
    const targetDate = new Date(targetYear, targetMonth - 1, 1);

    if (targetDate > maxDate) return;

    viewYear = targetYear;
    viewMonth = targetMonth;
    updateCalendar();
});

function updateCalendar() {
    calendarEl.innerHTML = '';
    currentMonthEl.textContent = `${viewYear}年 ${viewMonth}月`;

    const holidays = getAllHolidays(viewYear);

    const firstDay = new Date(viewYear, viewMonth - 1, 1);
    const lastDate = new Date(viewYear, viewMonth, 0).getDate();

    // ラベル（★月曜始まり）
    const labels = [ '日', '月', '火', '水', '木', '金', '土',];
    labels.forEach(labelText => {
        const label = document.createElement('div');
        label.className = 'day label';
        label.textContent = labelText;
        calendarEl.appendChild(label);
    });

    // 空白セル（★日曜始まりに）
    let shift = firstDay.getDay();

    for (let i = 0; i < shift; i++) {
        const blank = document.createElement('div');
        blank.className = 'day blank';
        calendarEl.appendChild(blank);
    }

    // 日付セル生成
    for (let date = 1; date <= lastDate; date++) {
        const current = new Date(viewYear, viewMonth - 1, date);
        const day = current.getDay();

        const cell = document.createElement('div');
        cell.className = 'day';

        // ↓ 修正②: cell.textContent = date; は削除しました
        // 代わりに日付番号専用のdivを作成して追加（↓）

        const number = document.createElement('div');
        number.className = 'date-number';

        // 元の日付番号を先に追加
        number.textContent = date;

        // スマホ用の曜日ラベル
        const weekday = document.createElement('span');
        weekday.className = 'weekday';

        // 曜日ラベル（日曜始まり）
        const weekdayLabels = ['日', '月', '火', '水', '木', '金', '土'];
        weekday.textContent = weekdayLabels[current.getDay()];

        // 日付の後ろに追加
        number.appendChild(weekday);

        cell.appendChild(number);


        // ymdフォーマット
        const ymd = `${viewYear}-${String(viewMonth).padStart(2, '0')}-${String(date).padStart(2, '0')}`;

        // ↓ 修正③: eventsMapにイベントがあれば差し込む
        if (eventsMap[ymd]) {
            const customContent = document.createElement('div');
            customContent.className = 'custom-content';
            customContent.innerHTML = eventsMap[ymd];
            cell.appendChild(customContent);
        }

        // 曜日クラス（★月曜始まり調整）
        const adjustedDay = day;
        if (adjustedDay === 0) cell.classList.add('sun');
        else if (adjustedDay === 6) cell.classList.add('sat');

        // 祝日クラス
        if (holidays[ymd]) {
            cell.classList.add('holiday');
            cell.title = holidays[ymd];
        }

        calendarEl.appendChild(cell);
    }



 // 画像ポップパップ 動的に生成された .popup-link にモーダル処理を紐付け
    const modal = document.getElementById('image-modal');
    const modalImg = document.getElementById('modal-img');

    calendarEl.querySelectorAll('.popup-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            modalImg.src = this.href;
            modal.style.display = 'flex';
        });
    });

    modal.addEventListener('click', function() {
        modal.style.display = 'none';
        modalImg.src = '';
    });

}

updateCalendar();


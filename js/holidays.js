function getAllHolidays(year) {
    const holidays = {};

    // 固定祝日
    const fixed = {
        "01-01": "元日",
        "02-11": "建国記念の日",
        "02-23": "天皇誕生日",
        "04-29": "昭和の日",
        "05-03": "憲法記念日",
        "05-04": "みどりの日",
        "05-05": "こどもの日",
        "08-11": "山の日",
        "11-03": "文化の日",
        "11-23": "勤労感謝の日"
    };

    // 固定日を年に合わせて登録
    for (const md in fixed) {
        holidays[`${year}-${md}`] = fixed[md];
    }

    // 可変祝日の追加
    const vernal = getVernalEquinox(year);
    const autumnal = getAutumnalEquinox(year);

    holidays[`${year}-${vernal}`] = "春分の日";
    holidays[`${year}-${autumnal}`] = "秋分の日";

    holidays[getHappyMonday(year, 1, 2)] = "成人の日";        // 1月第2月曜
    holidays[getHappyMonday(year, 7, 3)] = "海の日";          // 7月第3月曜
    holidays[getHappyMonday(year, 9, 3)] = "敬老の日";        // 9月第3月曜
    holidays[getHappyMonday(year, 10, 2)] = "スポーツの日";   // 10月第2月曜

    // ---------------------------
    // 天皇誕生日
    // ---------------------------
    if (year >= 2020) {
        holidays[`${year}-02-23`] = "天皇誕生日"; // 令和
    } else if (year >= 1989 && year <= 2018) {
        holidays[`${year}-12-23`] = "天皇誕生日"; // 平成
    }

    // ★ 振替休日
    const withSubstitute = addSubstituteHolidays(holidays);

    // ★ 国民の休日
    const withNational = addNationalHolidays(withSubstitute);

    return withNational;
}

function addSubstituteHolidays(holidays) {
    const newHolidays = { ...holidays };

    Object.entries(holidays).forEach(([dateStr, name]) => {
        const date = new Date(dateStr);
        if (date.getDay() === 0) { // 日曜なら振替休日判定開始
            let subDate = new Date(date);
            while (true) {
                subDate.setDate(subDate.getDate() + 1);
                const subDateStr = subDate.toISOString().slice(0, 10);
                if (!newHolidays[subDateStr]) {
                    newHolidays[subDateStr] = "振替休日";
                    break;
                }
            }
        }
    });

    return newHolidays;
}

// ---------------------------
// 国民の休日
// ---------------------------
function addNationalHolidays(holidays){
    const newHolidays = { ...holidays };
    const dates = Object.keys(holidays).sort();

    for(let i=0; i<dates.length-1; i++){
        const date1 = new Date(dates[i]);
        const date2 = new Date(dates[i+1]);

        const diff = (date2 - date1) / (1000*60*60*24);

        if(diff === 2){ // 前後の祝日に挟まれた平日1日
            const nh = new Date(date1);
            nh.setDate(nh.getDate()+1);
            const nhStr = nh.toISOString().slice(0,10);

            // 平日のみ追加（土日除外）
            if(!newHolidays[nhStr] && nh.getDay() !== 0 && nh.getDay() !== 6){
                newHolidays[nhStr] = "国民の休日";
            }
        }
    }

    return newHolidays;
}

// 春分の日（年によって変化、近似式）
function getVernalEquinox(year) {
    const d = Math.floor(20.8431 + 0.242194 * (year - 1980)) - Math.floor((year - 1980) / 4);
    return `03-${String(d).padStart(2, '0')}`;
}

// 秋分の日（年によって変化、近似式）
function getAutumnalEquinox(year) {
    const d = Math.floor(23.2488 + 0.242194 * (year - 1980)) - Math.floor((year - 1980) / 4);
    return `09-${String(d).padStart(2, '0')}`;
}

// ハッピーマンデー制度：第n月曜日を取得
function getHappyMonday(year, month, nth) {
    let count = 0;
    for (let day = 1; day <= 31; day++) {
        const date = new Date(year, month - 1, day);
        if (date.getMonth() !== month - 1) break;
        if (date.getDay() === 1) { // 月曜日
            count++;
            if (count === nth) {
                return `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            }
        }
    }
    return null;
}

/**
 * Formatte une date selon la locale
 */
export function formatDate(date, locale = 'fr-FR') {
    return new Intl.DateTimeFormat(locale, {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    }).format(new Date(date));
}

/**
 * Formatte une heure
 */
export function formatTime(date, locale = 'fr-FR') {
    return new Intl.DateTimeFormat(locale, {
        hour: '2-digit',
        minute: '2-digit',
    }).format(new Date(date));
}

/**
 * Formatte date et heure
 */
export function formatDateTime(date, locale = 'fr-FR') {
    return new Intl.DateTimeFormat(locale, {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    }).format(new Date(date));
}

/**
 * Calcule le temps écoulé (il y a X minutes/heures/jours)
 */
export function timeAgo(date, locale = 'fr') {
    const seconds = Math.floor((new Date() - new Date(date)) / 1000);
    
    const intervals = {
        fr: {
            year: 'an',
            years: 'ans',
            month: 'mois',
            months: 'mois',
            day: 'jour',
            days: 'jours',
            hour: 'heure',
            hours: 'heures',
            minute: 'minute',
            minutes: 'minutes',
            second: 'seconde',
            seconds: 'secondes',
            ago: 'il y a',
        },
        en: {
            year: 'year',
            years: 'years',
            month: 'month',
            months: 'months',
            day: 'day',
            days: 'days',
            hour: 'hour',
            hours: 'hours',
            minute: 'minute',
            minutes: 'minutes',
            second: 'second',
            seconds: 'seconds',
            ago: 'ago',
        },
    };
    
    const i18n = intervals[locale] || intervals.fr;
    
    let interval = Math.floor(seconds / 31536000);
    if (interval >= 1) {
        return `${i18n.ago} ${interval} ${interval === 1 ? i18n.year : i18n.years}`;
    }
    
    interval = Math.floor(seconds / 2592000);
    if (interval >= 1) {
        return `${i18n.ago} ${interval} ${interval === 1 ? i18n.month : i18n.months}`;
    }
    
    interval = Math.floor(seconds / 86400);
    if (interval >= 1) {
        return `${i18n.ago} ${interval} ${interval === 1 ? i18n.day : i18n.days}`;
    }
    
    interval = Math.floor(seconds / 3600);
    if (interval >= 1) {
        return `${i18n.ago} ${interval} ${interval === 1 ? i18n.hour : i18n.hours}`;
    }
    
    interval = Math.floor(seconds / 60);
    if (interval >= 1) {
        return `${i18n.ago} ${interval} ${interval === 1 ? i18n.minute : i18n.minutes}`;
    }
    
    return `${i18n.ago} ${Math.floor(seconds)} ${Math.floor(seconds) === 1 ? i18n.second : i18n.seconds}`;
}

/**
 * Vérifie si un restaurant est ouvert
 */
export function isRestaurantOpen(openingHours) {
    if (!openingHours) return false;
    
    const now = new Date();
    const dayOfWeek = now.getDay(); // 0 = Dimanche, 1 = Lundi, etc.
    const currentTime = now.getHours() * 60 + now.getMinutes(); // Minutes depuis minuit
    
    const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    const today = days[dayOfWeek];
    
    if (!openingHours[today]) return false;
    
    const { open, close } = openingHours[today];
    const [openHour, openMinute] = open.split(':').map(Number);
    const [closeHour, closeMinute] = close.split(':').map(Number);
    
    const openingTime = openHour * 60 + openMinute;
    const closingTime = closeHour * 60 + closeMinute;
    
    return currentTime >= openingTime && currentTime <= closingTime;
}


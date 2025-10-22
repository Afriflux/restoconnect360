/**
 * Valide un email
 */
export function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

/**
 * Valide un numéro de téléphone sénégalais
 */
export function isValidSenegalPhone(phone) {
    // Format: +221771234567 ou 771234567
    const re = /^(\+221)?[0-9]{9}$/;
    return re.test(phone.replace(/\s/g, ''));
}

/**
 * Valide un numéro de téléphone africain
 */
export function isValidAfricanPhone(phone) {
    // Format: +XXX suivi de 9-10 chiffres
    const re = /^\+[0-9]{1,3}[0-9]{9,10}$/;
    return re.test(phone.replace(/\s/g, ''));
}

/**
 * Valide un mot de passe
 */
export function isValidPassword(password, minLength = 8) {
    if (password.length < minLength) return false;
    
    // Au moins une lettre majuscule, une minuscule, un chiffre
    const hasUpperCase = /[A-Z]/.test(password);
    const hasLowerCase = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    
    return hasUpperCase && hasLowerCase && hasNumber;
}

/**
 * Valide un montant
 */
export function isValidAmount(amount, min = 0, max = Infinity) {
    const num = parseFloat(amount);
    return !isNaN(num) && num >= min && num <= max;
}

/**
 * Valide des coordonnées GPS
 */
export function isValidCoordinates(latitude, longitude) {
    const lat = parseFloat(latitude);
    const lng = parseFloat(longitude);
    
    return (
        !isNaN(lat) &&
        !isNaN(lng) &&
        lat >= -90 &&
        lat <= 90 &&
        lng >= -180 &&
        lng <= 180
    );
}

/**
 * Nettoie un numéro de téléphone
 */
export function cleanPhone(phone) {
    return phone.replace(/\s/g, '').replace(/^00/, '+');
}

/**
 * Formate un numéro de téléphone sénégalais
 */
export function formatSenegalPhone(phone) {
    const cleaned = cleanPhone(phone);
    
    if (cleaned.startsWith('+221')) {
        const number = cleaned.substring(4);
        return `+221 ${number.substring(0, 2)} ${number.substring(2, 5)} ${number.substring(5)}`;
    }
    
    if (cleaned.length === 9) {
        return `${cleaned.substring(0, 2)} ${cleaned.substring(2, 5)} ${cleaned.substring(5)}`;
    }
    
    return phone;
}


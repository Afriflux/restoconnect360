/**
 * Formatte un montant en CFA
 */
export function formatCurrency(amount, locale = 'fr-FR') {
    return new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: 'XOF',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(amount);
}

/**
 * Formatte un montant simple sans symbole
 */
export function formatAmount(amount) {
    return new Intl.NumberFormat('fr-FR', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(amount);
}

/**
 * Convertit un montant en centimes
 */
export function toCents(amount) {
    return Math.round(amount * 100);
}

/**
 * Convertit des centimes en montant
 */
export function fromCents(cents) {
    return cents / 100;
}

/**
 * Calcule la TVA (18% au Sénégal)
 */
export function calculateTax(amount, rate = 0.18) {
    return amount * rate;
}

/**
 * Calcule le total TTC
 */
export function calculateTotal(subtotal, taxRate = 0.18, deliveryFee = 0) {
    const tax = calculateTax(subtotal, taxRate);
    return subtotal + tax + deliveryFee;
}


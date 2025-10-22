import { ref } from 'vue';
import axios from 'axios';

export function usePayment() {
    const loading = ref(false);
    const error = ref(null);
    const paymentUrl = ref(null);

    const initiateCinetPay = async (amount, orderId, customerInfo) => {
        loading.value = true;
        error.value = null;

        try {
            const response = await axios.post('/api/payments/cinetpay/initiate', {
                amount,
                order_id: orderId,
                customer_name: customerInfo.name,
                customer_email: customerInfo.email,
                customer_phone: customerInfo.phone,
            });

            paymentUrl.value = response.data.payment_url;
            return response.data;
        } catch (err) {
            error.value = err.response?.data?.message || 'Payment initiation failed';
            throw err;
        } finally {
            loading.value = false;
        }
    };

    const initiatePayTech = async (amount, orderId, customerInfo) => {
        loading.value = true;
        error.value = null;

        try {
            const response = await axios.post('/api/payments/paytech/initiate', {
                amount,
                order_id: orderId,
                customer_name: customerInfo.name,
                customer_email: customerInfo.email,
                customer_phone: customerInfo.phone,
            });

            paymentUrl.value = response.data.payment_url;
            return response.data;
        } catch (err) {
            error.value = err.response?.data?.message || 'Payment initiation failed';
            throw err;
        } finally {
            loading.value = false;
        }
    };

    const verifyPayment = async (transactionId, provider = 'cinetpay') => {
        loading.value = true;
        error.value = null;

        try {
            const response = await axios.post(`/api/payments/${provider}/verify`, {
                transaction_id: transactionId,
            });

            return response.data;
        } catch (err) {
            error.value = err.response?.data?.message || 'Payment verification failed';
            throw err;
        } finally {
            loading.value = false;
        }
    };

    const processCashPayment = async (orderId, amount) => {
        loading.value = true;
        error.value = null;

        try {
            const response = await axios.post('/api/payments/cash', {
                order_id: orderId,
                amount,
            });

            return response.data;
        } catch (err) {
            error.value = err.response?.data?.message || 'Cash payment failed';
            throw err;
        } finally {
            loading.value = false;
        }
    };

    return {
        loading,
        error,
        paymentUrl,
        initiateCinetPay,
        initiatePayTech,
        verifyPayment,
        processCashPayment,
    };
}


import { ref, onMounted, onUnmounted } from 'vue';

export function useGeolocation() {
    const latitude = ref(null);
    const longitude = ref(null);
    const error = ref(null);
    const loading = ref(false);
    const watchId = ref(null);

    const getCurrentPosition = () => {
        loading.value = true;
        error.value = null;

        if (!('geolocation' in navigator)) {
            error.value = 'Geolocation is not supported by your browser';
            loading.value = false;
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                latitude.value = position.coords.latitude;
                longitude.value = position.coords.longitude;
                loading.value = false;
            },
            (err) => {
                error.value = err.message;
                loading.value = false;
            },
            {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0,
            }
        );
    };

    const watchPosition = (callback) => {
        if (!('geolocation' in navigator)) {
            error.value = 'Geolocation is not supported by your browser';
            return;
        }

        watchId.value = navigator.geolocation.watchPosition(
            (position) => {
                latitude.value = position.coords.latitude;
                longitude.value = position.coords.longitude;
                if (callback) {
                    callback({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                    });
                }
            },
            (err) => {
                error.value = err.message;
            },
            {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0,
            }
        );
    };

    const clearWatch = () => {
        if (watchId.value !== null) {
            navigator.geolocation.clearWatch(watchId.value);
            watchId.value = null;
        }
    };

    const calculateDistance = (lat1, lon1, lat2, lon2) => {
        // Formule Haversine pour calculer la distance entre deux points
        const R = 6371; // Rayon de la Terre en km
        const dLat = toRad(lat2 - lat1);
        const dLon = toRad(lon2 - lon1);
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(toRad(lat1)) *
                Math.cos(toRad(lat2)) *
                Math.sin(dLon / 2) *
                Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const distance = R * c;
        return distance; // Distance en km
    };

    const toRad = (value) => {
        return (value * Math.PI) / 180;
    };

    onMounted(() => {
        getCurrentPosition();
    });

    onUnmounted(() => {
        clearWatch();
    });

    return {
        latitude,
        longitude,
        error,
        loading,
        getCurrentPosition,
        watchPosition,
        clearWatch,
        calculateDistance,
    };
}


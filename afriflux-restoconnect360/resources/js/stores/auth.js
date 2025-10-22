import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
    state: () => {
        // Initialiser l'état depuis localStorage
        const savedUser = localStorage.getItem('auth_user');
        const user = savedUser ? JSON.parse(savedUser) : null;
        
        return {
            user: user,
            token: localStorage.getItem('token') || null,
            isAuthenticated: user ? user.isAuthenticated : false,
            loading: false,
            error: null,
        };
    },

    getters: {
        currentUser: (state) => state.user,
        isSuperAdmin: (state) => state.user?.role === 'super_admin',
        isAdmin: (state) => state.user?.role === 'admin',
        isCompanyManager: (state) => state.user?.role === 'company_manager',
        isRestaurantManager: (state) => state.user?.role === 'restaurant_manager',
        isAgent: (state) => state.user?.role === 'agent',
        isEmployee: (state) => state.user?.role === 'employee',
        isDriver: (state) => state.user?.role === 'driver',
        userRole: (state) => state.user?.role || null,
        hasPermission: (state) => (permission) => {
            return state.user?.permissions?.includes(permission) || false;
        },
    },

    actions: {
        async login(credentials) {
            this.loading = true;
            this.error = null;
            
            try {
                // Simulation d'authentification pour les comptes de test
                const testAccounts = {
                    'super@restoconnect360.com': {
                        id: 1,
                        name: 'Super Admin',
                        email: 'super@restoconnect360.com',
                        role: 'super_admin',
                        roles: [{ name: 'super_admin' }],
                        permissions: ['*'],
                        isAuthenticated: true
                    },
                    'admin@restoconnect360.com': {
                        id: 2,
                        name: 'Admin',
                        email: 'admin@restoconnect360.com',
                        role: 'admin',
                        roles: [{ name: 'admin' }],
                        permissions: ['admin.*'],
                        isAuthenticated: true
                    },
                    'manager@restaurantdakar.com': {
                        id: 3,
                        name: 'Restaurant Manager',
                        email: 'manager@restaurantdakar.com',
                        role: 'restaurant_manager',
                        roles: [{ name: 'restaurant_manager' }],
                        permissions: ['restaurant.*'],
                        isAuthenticated: true
                    },
                    'driver1@restoconnect360.com': {
                        id: 4,
                        name: 'Driver',
                        email: 'driver1@restoconnect360.com',
                        role: 'driver',
                        roles: [{ name: 'driver' }],
                        permissions: ['delivery.*'],
                        isAuthenticated: true
                    }
                };

                const { email, password } = credentials;

                // 1) Comptes de test (simulation)
                if (password === 'password' && testAccounts[email]) {
                    const user = testAccounts[email];
                    const token = 'test_token_' + Date.now();

                    this.token = token;
                    this.user = user;
                    this.isAuthenticated = true;

                    localStorage.setItem('token', token);
                    localStorage.setItem('auth_user', JSON.stringify(user));
                    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

                    return { user, token };
                }

                // 2) Sinon: tentative de login via l'API Laravel
                const response = await axios.post('/api/login', { email, password });
                // Attendu: { token, user }
                const apiToken = response.data?.token || response.data?.access_token;
                const apiUser = response.data?.user || response.data;

                if (!apiUser) {
                    throw new Error('Réponse serveur invalide');
                }

                this.token = apiToken || null;
                this.user = {
                    ...apiUser,
                    // Normaliser la structure pour le router (roles array + role string)
                    role: apiUser.role || apiUser?.roles?.[0]?.name || 'admin',
                    roles: apiUser.roles || (apiUser.role ? [{ name: apiUser.role }] : []),
                    isAuthenticated: true,
                };
                this.isAuthenticated = true;

                if (this.token) {
                    localStorage.setItem('token', this.token);
                    axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                }
                localStorage.setItem('auth_user', JSON.stringify(this.user));

                return { user: this.user, token: this.token };
            } catch (error) {
                this.error = error.message || 'Login failed';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async register(userData) {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await axios.post('/api/register', userData);
                this.token = response.data.token;
                this.user = response.data.user;
                this.isAuthenticated = true;
                
                localStorage.setItem('token', this.token);
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                
                return response.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Registration failed';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async logout() {
            try {
                await axios.post('/api/logout');
            } catch (error) {
                console.error('Logout error:', error);
            } finally {
                this.token = null;
                this.user = null;
                this.isAuthenticated = false;
                localStorage.removeItem('token');
                localStorage.removeItem('auth_user');
                delete axios.defaults.headers.common['Authorization'];
            }
        },

        async fetchUser() {
            if (!this.token) return;
            
            try {
                const response = await axios.get('/api/user');
                this.user = response.data;
                this.isAuthenticated = true;
            } catch (error) {
                this.logout();
            }
        },

        setToken(token) {
            this.token = token;
            localStorage.setItem('token', token);
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        },

        setUser(userData) {
            this.user = userData;
            this.isAuthenticated = userData.isAuthenticated || false;
            localStorage.setItem('auth_user', JSON.stringify(userData));
        },

        initializeAuth() {
            const savedUser = localStorage.getItem('auth_user');
            const savedToken = localStorage.getItem('token');
            if (savedUser) {
                const user = JSON.parse(savedUser);
                this.user = user;
                this.isAuthenticated = user.isAuthenticated || false;
            }
            if (savedToken) {
                this.token = savedToken;
                axios.defaults.headers.common['Authorization'] = `Bearer ${savedToken}`;
            }
        },
    },
});


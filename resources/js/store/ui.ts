import { create } from 'zustand';

type AuthView = 'login' | 'register';

interface UIState {
    isAuthModalOpen: boolean;
    authView: AuthView;
    isSearchOpen: boolean;
    openAuthModal: (view?: AuthView) => void;
    closeAuthModal: () => void;
    setAuthView: (view: AuthView) => void;
    openSearch: () => void;
    closeSearch: () => void;
}

export const useUIStore = create<UIState>((set) => ({
    isAuthModalOpen: false,
    authView: 'login',
    isSearchOpen: false,
    openAuthModal: (view = 'login') => set({ isAuthModalOpen: true, authView: view }),
    closeAuthModal: () => set({ isAuthModalOpen: false }),
    setAuthView: (view) => set({ authView: view }),
    openSearch: () => set({ isSearchOpen: true }),
    closeSearch: () => set({ isSearchOpen: false }),
}));

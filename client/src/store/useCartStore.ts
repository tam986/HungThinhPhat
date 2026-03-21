import { create } from 'zustand';
import { persist } from 'zustand/middleware';

export interface CartItem {
    id: string | number;
    id_bienthe: string | number;
    name: string;
    price: number;
    quantity: number;
    image?: string;
    weight?: string;
}

interface CartState {
    items: CartItem[];
    addItem: (item: CartItem) => void;
    removeItem: (id_bienthe: string | number) => void;
    updateQuantity: (id_bienthe: string | number, quantity: number) => void;
    clearCart: () => void;
    getTotalItems: () => number;
    getTotalPrice: () => number;
}

export const useCartStore = create<CartState>()(
    persist(
        (set, get) => ({
            items: [],
            addItem: (item) => {
                const currentItems = get().items;
                const existingItem = currentItems.find(i => i.id_bienthe === item.id_bienthe);

                if (existingItem) {
                    set({
                        items: currentItems.map(i =>
                            i.id_bienthe === item.id_bienthe
                                ? { ...i, quantity: i.quantity + item.quantity }
                                : i
                        )
                    });
                } else {
                    set({ items: [...currentItems, item] });
                }
            },
            removeItem: (id_bienthe) => {
                set({ items: get().items.filter(i => i.id_bienthe !== id_bienthe) });
            },
            updateQuantity: (id_bienthe, quantity) => {
                set({
                    items: get().items.map(i =>
                        i.id_bienthe === id_bienthe ? { ...i, quantity: Math.max(1, quantity) } : i
                    )
                });
            },
            clearCart: () => set({ items: [] }),
            getTotalItems: () => get().items.reduce((total, item) => total + item.quantity, 0),
            getTotalPrice: () => get().items.reduce((total, item) => total + (item.price * item.quantity), 0),
        }),
        {
            name: 'cart-storage',
        }
    )
);

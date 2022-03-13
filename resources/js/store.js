import {isLoggedIn, logOut} from "./components/shared/utils/auth";

export default {
    state: {
        lastSearch: {
            from: null,
            to: null
        },
        basket: {
            items: []
        },
        isLoggedIn: false,
        user:{}
    },
    mutations: {
        setLastSearch(state, payload) {
            state.lastSearch = payload;
        },
        addToBasket(state, payload) {
            state.basket.items.push(payload);
        },
        removeFromBasket(state, payload) {
            state.basket.items = state.basket.items.filter(item => item.bookable.id !== payload)
        },
        setBasket(state, payload) {
            state.basket = payload;
        },
        setUser(state,payload) {
            state.user = payload;
        },
        setLoggedIn(state,payload) {
            state.isLoggedIn = payload;
        }
    },
    actions: {
        setLastSearch(context, payload) {
            context.commit('setLastSearch',payload);
            localStorage.setItem('lastSearch', JSON.stringify(payload));
        },
        loadStoredState(context) {
            const lastSearch = localStorage.getItem('lastSearch');
            if(lastSearch) {
                context.commit('setLastSearch', JSON.parse(lastSearch));
            }
            const basket = localStorage.getItem('basket');
            if(basket) {
                context.commit('setBasket', JSON.parse(basket));
            }
        },
        addToBasket({commit,state}, payload) {
            commit('addToBasket',payload);
            localStorage.setItem('basket',JSON.stringify(state.basket));

        },
        removeFromBasket({commit,state}, payload) {
            commit('removeFromBasket',payload);
            localStorage.setItem('basket',JSON.stringify(state.basket));
        },
        emptyBasket({commit,state}, payload) {
            commit('setBasket', {items: []});
            localStorage.setItem('basket', JSON.stringify(state.basket));
        },
       async loadUser({commit,dispatch}, payload) {
           if (isLoggedIn()) {
               try {
                   const user = (await axios.get('/user')).data;
                   commit('setUser', user);
                   commit('setLoggedIn', true);
               } catch (err) {
                   dispatch('logOut');
               }
           }
       },
        logOut({commit}) {
            commit('setUser',{});
            commit('isLoggedIn', false);
            logOut();
        }
    },
    getters: {
        itemsInBasket: (state) => state.basket.items.length,
        inBasketAlready(state) {
            return function(id) {
                return state.basket.items.reduce((result, item)=> result || id === item.bookable.id , false)
            }
        }

    }
}

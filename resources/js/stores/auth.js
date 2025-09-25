import { defineStore } from "pinia";
import { ref } from "vue";

export const useAuthStore = defineStore("auth", () => {
    const user = ref(null);

    function setUser(newUser) {
        user.value = newUser;
    }

    function hasPermission(permission) {
        return user.value?.permissions?.includes(permission) ?? false;
    }

    function clearUser() {
        user.value = null;
    }

    return { user, setUser, hasPermission, clearUser };
});

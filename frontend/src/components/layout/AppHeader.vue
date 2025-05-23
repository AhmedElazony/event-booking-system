<template>
  <header class="bg-white dark:bg-gray-900 shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <div class="flex-shrink-0 flex items-center">
            <router-link to="/" class="flex items-center space-x-2">
              <span class="text-xl font-bold text-indigo-600">EventSystem</span>
            </router-link>
          </div>
          <nav
            class="hidden md:ml-8 md:flex md:space-x-8"
            aria-label="Main navigation"
          >
            <NavLink to="/">Home</NavLink>
            <NavLink to="/events" name="Events">Events</NavLink>
            <NavLink to="/categories" name="Categories">Categories</NavLink>
            <NavLink
              v-if="isLoggedIn && !isAdmin"
              to="/bookings"
              name="My Bookings"
              >My Bookings</NavLink
            >
          </nav>
        </div>

        <!-- Right side navigation -->
        <div class="hidden md:flex md:items-center md:space-x-4">
          <!-- Add the dark mode toggle button -->
          <ToggleDarkModeButton />
          <div v-if="isLoggedIn" class="relative">
            <button
              @click="isMenuOpen = !isMenuOpen"
              class="flex items-center space-x-2 text-sm focus:outline-none group"
              id="user-menu"
              aria-expanded="false"
              aria-haspopup="true"
            >
              <div
                class="h-8 w-8 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-medium shadow-sm overflow-hidden transition-all duration-200 group-hover:shadow-md"
              >
                {{ userInitials }}
              </div>
              <span class="hidden lg:inline text-gray-700">{{
                user?.name || "User"
              }}</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4 text-gray-500 group-hover:text-indigo-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                />
              </svg>
            </button>

            <div
              v-if="isMenuOpen"
              class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
              role="menu"
              aria-orientation="vertical"
              aria-labelledby="user-menu"
              @focusout="closeMenuOnFocusOut"
              v-click-outside="() => (isMenuOpen = false)"
            >
              <router-link
                to="/profile"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                role="menuitem"
              >
                <div class="flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-2 text-gray-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                  </svg>
                  Your Profile
                </div>
              </router-link>
              <router-link
                v-if="isAdmin"
                to="/admin/events"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                role="menuitem"
              >
                <div class="flex items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-2 text-gray-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                    />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                  </svg>
                  Admin Dashboard
                </div>
              </router-link>
              <div class="border-t border-gray-100 my-1"></div>
              <a
                @click.prevent="logout"
                href="#"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                role="menuitem"
              >
                <div class="flex items-center text-red-600">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 mr-2"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                    />
                  </svg>
                  Sign out
                </div>
              </a>
            </div>
          </div>

          <div v-else class="flex items-center space-x-3">
            <router-link
              to="/login"
              class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200"
            >
              Log in
            </router-link>
            <router-link
              to="/register"
              class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium shadow hover:shadow-md transition-all duration-200"
            >
              Sign up
            </router-link>
          </div>
        </div>

        <!-- Mobile menu button -->
        <div class="flex items-center md:hidden">
          <button
            @click.stop="toggleMobileMenu"
            type="button"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100"
            :aria-expanded="isMobileMenuOpen"
          >
            <span class="sr-only">{{
              isMobileMenuOpen ? "Close menu" : "Open menu"
            }}</span>
            <svg
              v-if="!isMobileMenuOpen"
              class="block h-6 w-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              aria-hidden="true"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
            <svg
              v-else
              class="block h-6 w-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              aria-hidden="true"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div
      v-show="isMobileMenuOpen"
      class="md:hidden shadow-lg border-t bg-white dark:bg-gray-900 transition-all duration-200"
      ref="mobileMenu"
    >
      <div class="pt-2 pb-3 space-y-1">
        <router-link
          to="/"
          class="block pl-3 pr-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-800 dark:text-white"
          :class="
            $route.path === '/'
              ? 'border-l-4 border-indigo-500 text-indigo-600 font-medium'
              : 'border-l-4 border-transparent text-gray-600'
          "
          @click="isMobileMenuOpen = false"
        >
          Home
        </router-link>
        <router-link
          to="/events"
          class="block pl-3 pr-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-800 dark:text-white"
          :class="
            $route.path.includes('/events')
              ? 'border-l-4 border-indigo-500 text-indigo-600 font-medium'
              : 'border-l-4 border-transparent text-gray-600'
          "
          @click="isMobileMenuOpen = false"
        >
          Events
        </router-link>
        <router-link
          to="/categories"
          class="block pl-3 pr-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-800 dark:text-white"
          :class="
            $route.path.includes('/categories')
              ? 'border-l-4 border-indigo-500 text-indigo-600 font-medium'
              : 'border-l-4 border-transparent text-gray-600'
          "
          @click="isMobileMenuOpen = false"
        >
          Categories
        </router-link>
        <router-link
          v-if="isLoggedIn && !isAdmin"
          to="/bookings"
          class="block pl-3 pr-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-800 dark:text-white"
          :class="
            $route.path.includes('/bookings')
              ? 'border-l-4 border-indigo-500 text-indigo-600 font-medium'
              : 'border-l-4 border-transparent text-gray-600'
          "
          @click="isMobileMenuOpen = false"
        >
          My Bookings
        </router-link>
      </div>

      <!-- Dark Mode Toggle for Mobile -->
      <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-500">
        <ToggleDarkModeButton />
      </div>

      <div v-if="isLoggedIn" class="pt-4 pb-3 border-t border-gray-500">
        <div class="flex items-center px-4 py-2">
          <div class="flex-shrink-0">
            <div
              class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-medium"
            >
              {{ userInitials }}
            </div>
          </div>
          <div class="ml-3">
            <div class="text-base font-medium text-gray-800 dark:text-white">
              {{ user?.name || "User" }}
            </div>
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ user?.email }}
            </div>
          </div>
        </div>
        <div class="mt-3 space-y-1">
          <router-link
            to="/profile"
            class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:text-white"
            @click="isMobileMenuOpen = false"
          >
            Your Profile
          </router-link>
          <router-link
            v-if="isAdmin"
            to="/admin"
            class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:text-white"
            @click="isMobileMenuOpen = false"
          >
            Admin Dashboard
          </router-link>
          <a
            @click.prevent="logout"
            href="#"
            class="block px-4 py-2 text-base font-medium text-red-600 hover:bg-gray-50"
          >
            Sign out
          </a>
        </div>
      </div>

      <div v-else class="pt-4 pb-3 border-t border-gray-200">
        <div class="flex flex-col space-y-2 px-4">
          <router-link
            to="/login"
            class="w-full text-center py-2 text-indigo-600 border border-indigo-600 rounded-md hover:bg-indigo-50 transition-colors duration-200"
            @click="isMobileMenuOpen = false"
          >
            Log in
          </router-link>
          <router-link
            to="/register"
            class="w-full text-center py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200"
            @click="isMobileMenuOpen = false"
          >
            Sign up
          </router-link>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useAuthStore } from "../../stores/auth";
import ToggleDarkModeButton from "../ui/ToggleDarkModeButton.vue";
import NavLink from "../ui/NavLink.vue";

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();

const isMenuOpen = ref(false);
const isMobileMenuOpen = ref(false);
const mobileMenu = ref(null);

const user = computed(() => authStore.user);
const isLoggedIn = computed(() => authStore.isLoggedIn());
const isAdmin = computed(
  () => user.value?.role === "admin" || user.value?.role === "super_admin"
);

const userInitials = computed(() => {
  if (!user.value?.name) return "";

  const names = user.value.name.split(" ");
  if (names.length === 1) return names[0].charAt(0).toUpperCase();
  return (names[0].charAt(0) + names[names.length - 1].charAt(0)).toUpperCase();
});

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const handleEscKey = (event) => {
  if (event.key === "Escape" && isMobileMenuOpen.value) {
    isMobileMenuOpen.value = false;
  }
};

const logout = async () => {
  await authStore.logout();
  isMenuOpen.value = false;
  isMobileMenuOpen.value = false;
  router.push("/");
};

const closeMenuOnFocusOut = (event) => {
  if (!event.currentTarget.contains(event.relatedTarget)) {
    isMenuOpen.value = false;
  }
};

// Close mobile menu when clicking outside
const handleClickOutside = (event) => {
  if (
    isMobileMenuOpen.value &&
    mobileMenu.value &&
    !mobileMenu.value.contains(event.target)
  ) {
    isMobileMenuOpen.value = false;
  }
};

// Click outside directive
const vClickOutside = {
  mounted(el, binding) {
    el.clickOutsideEvent = (event) => {
      if (!(el === event.target || el.contains(event.target))) {
        binding.value(event);
      }
    };
    document.addEventListener("click", el.clickOutsideEvent, { capture: true });
  },
  unmounted(el) {
    document.removeEventListener("click", el.clickOutsideEvent, {
      capture: true,
    });
  },
};

// Close mobile menu on route change
onMounted(() => {
  document.addEventListener("click", handleClickOutside);
  document.addEventListener("keydown", handleEscKey);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
  document.removeEventListener("keydown", handleEscKey);
});
</script>

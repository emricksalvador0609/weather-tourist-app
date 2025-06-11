<template>
  <div>
    <div class="min-h-screen bg-gradient-to-br from-blue-100 to-white dark:from-gray-900 dark:to-gray-800 py-6 px-4 pb-24">
      <div class="max-w-3xl mx-auto bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 shadow-xl rounded-2xl p-6">

        <!-- Dark Mode Toggle -->
        <div class="flex justify-end mb-4">
          <button
            @click="isDark = !isDark"
            class="px-3 py-1 rounded-md bg-blue-200 dark:bg-gray-700 text-sm hover:bg-blue-300 dark:hover:bg-gray-600 transition"
          >
            {{ isDark ? 'Light Mode ☀️' : 'Dark Mode 🌙' }}
          </button>
        </div>

        <!-- App Header -->
        <h1 class="text-3xl font-bold text-blue-800 dark:text-blue-300 mb-4 text-center">
          Japan Travel Info
        </h1>

        <!-- City Selector -->
        <div class="mb-6 flex flex-col sm:flex-row justify-center gap-4">
          <select v-model="city" @change="loadData" class="p-2 border rounded-md text-lg shadow">
            <option v-for="c in cities" :key="c" :value="c">{{ c }}</option>
          </select>
        </div>

        <!-- Search Filter -->
        <input v-model="filterKeyword" type="text" placeholder="Search places..." class="p-2 border rounded-md text-base w-full sm:w-1/2 mx-auto mb-4 shadow" />

        <!-- Loading Spinner -->
        <div v-if="loading" class="text-center my-6">
          <svg class="animate-spin h-8 w-8 text-blue-500 mx-auto" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75 fill-blue-500" d="M4 12a8 8 0 018-8V0C5.373...z"/>
          </svg>
          <p class="text-sm mt-2 text-blue-600 dark:text-blue-300">Loading data for {{ city }}...</p>
        </div>

        <!-- Weather Forecast -->
        <div ref="weatherSection" v-if="weather.list">
          <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-3">5-Day Weather Forecast</h2>
          <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
            <div
              v-for="(w, idx) in weather.list.slice(0, 5)"
              :key="idx"
              class="bg-blue-50 dark:bg-gray-800 rounded-lg p-4 shadow-md hover:shadow-lg transition duration-200"
            >
              <p class="text-sm text-gray-500 dark:text-gray-400">{{ new Date(w.dt_txt).toLocaleDateString() }}</p>
              <p class="text-xl font-bold text-blue-700 dark:text-blue-300">{{ w.main.temp }}°C</p>
              <div class="flex items-center gap-2 mt-2">
                <img :src="`https://openweathermap.org/img/wn/${w.weather[0].icon}.png`" alt="icon" />
                <p class="text-lg capitalize">{{ w.weather[0].description }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Places -->
        <div ref="placesSection" v-if="filteredPlaces.length" class="mt-10">
          <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-3">Top Places to Visit</h2>
          <div class="grid gap-4 sm:grid-cols-2">
            <div
              v-for="place in filteredPlaces"
              :key="place.fsq_id"
              class="bg-white dark:bg-gray-800 border rounded-lg p-4 shadow hover:shadow-lg transition duration-200"
            >
              <h3 class="text-lg font-bold text-blue-800 dark:text-blue-200">{{ place.name }}</h3>
              <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                {{ place.location?.formatted_address || place.location?.address }}
              </p>
            </div>
          </div>
        </div>

        <!-- Map -->
        <div ref="mapSection" class="mt-10">
          <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-3">City Map</h2>
             <iframe
            class="w-full h-64 rounded-lg"
            :src="`https://www.google.com/maps?q=${city},Japan&output=embed`"
            allowfullscreen=""
            loading="lazy"
          ></iframe>
        </div>
      </div>
    </div>

    <!-- Bottom Mobile Navigation -->
    <div class="fixed w-full bottom-0 left-0 right-0 bg-white dark:bg-gray-900 shadow-inner border-t dark:border-gray-700 flex justify-around py-2 sm:hidden z-50">
      <button @click="scrollTo('weatherSection')" :class="navActive === 'weatherSection' ? 'text-blue-600 dark:text-blue-300 font-bold' : 'text-gray-600 dark:text-gray-300'" class="flex flex-col items-center text-sm">
        <span>🌤</span>
        <span>Weather</span>
      </button>
      <button @click="scrollTo('placesSection')" :class="navActive === 'placesSection' ? 'text-blue-600 dark:text-blue-300 font-bold' : 'text-gray-600 dark:text-gray-300'" class="flex flex-col items-center text-sm">
        <span>📍</span>
        <span>Places</span>
      </button>
      <button @click="scrollTo('mapSection')" :class="navActive === 'mapSection' ? 'text-blue-600 dark:text-blue-300 font-bold' : 'text-gray-600 dark:text-gray-300'" class="flex flex-col items-center text-sm">
        <span>🗺</span>
        <span>Map</span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      city: 'Tokyo',
      cities: ['Tokyo', 'Yokohama', 'Kyoto', 'Osaka', 'Sapporo', 'Nagoya'],
      weather: {},
      places: {},
      isDark: false,
      loading: false,
      filterKeyword: '',
      navActive: 'weatherSection'
    };
  },
  watch: {
    isDark(newVal) {
      const root = document.documentElement;
      if (newVal) {
        root.classList.add('dark');
        localStorage.setItem('theme', 'dark');
      } else {
        root.classList.remove('dark');
        localStorage.setItem('theme', 'light');
      }
    }
  },
  mounted() {
    this.loadData();
    const savedTheme = localStorage.getItem('theme');
    this.isDark = savedTheme === 'dark';
    if (this.isDark) document.documentElement.classList.add('dark');

    window.addEventListener('scroll', this.handleScroll);
  },
  beforeDestroy() {
    window.removeEventListener('scroll', this.handleScroll);
  },
  methods: {
    async loadData() {
      this.loading = true;
      try {
        const weatherRes = await fetch(`/api/weather?city=${this.city}`);
        this.weather = await weatherRes.json();
        const placeRes = await fetch(`/api/places?city=${this.city}`);
        this.places = await placeRes.json();
      } catch (e) {
        console.error('Error loading data:', e);
      } finally {
        this.loading = false;
      }
    },
    scrollTo(refName) {
      const section = this.$refs[refName];
      if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
        this.navActive = refName;
      }
    },
    handleScroll() {
      const sections = ['weatherSection', 'placesSection', 'mapSection'];
      for (let sec of sections) {
        const el = this.$refs[sec];
        if (el) {
          const rect = el.getBoundingClientRect();
          if (rect.top <= 100 && rect.bottom >= 100) {
            this.navActive = sec;
            break;
          }
        }
      }
    }
  },
  computed: {
    filteredPlaces() {
      if (!this.places.results) return [];
      return this.places.results.filter(p =>
        p.name.toLowerCase().includes(this.filterKeyword.toLowerCase())
      );
    }
  }
};
</script>

<style>
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
</style>

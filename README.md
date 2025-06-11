# 🇯🇵 Japan Travel Info Web App

A responsive, modern travel information app for foreign tourists visiting Japan. Built using **Laravel 12**, **Vue 3**, **TailwindCSS**, and **Vite**, the app provides real-time weather forecasts and top places to visit for six major Japanese cities.

---

## 🌐 Tech Stack

- **Backend:** Laravel 12 (API endpoints)
- **Frontend:** Vue 3 with Options API
- **Styling:** TailwindCSS 4 (Dark Mode supported)
- **Build Tool:** Vite
- **APIs:**
  - [OpenWeatherMap 5-Day Forecast API](https://openweathermap.org/forecast5)
  - [Foursquare Places API](https://developer.foursquare.com/docs/places-api)

---

## 🚀 Features

- 🌤 **Weather Forecast**: 5-day forecast using OpenWeatherMap.
- 📍 **Places to Visit**: Top 5 venues using Foursquare API.
- 🌗 **Dark Mode**: Local storage-based toggle for better UX.
- 📱 **Responsive Design**: Mobile-first layout with bottom navigation.
- 🔍 **Place Filter**: Real-time search filtering for places.

---

## ⚙️ Setup, API Keys, and Run Project

### 1. Clone the repo

```bash
git clone https://github.com/your-username/japan-travel-app.git
cd japan-travel-app
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Set environment variables

Create a `.env` file in the root directory and add your API keys:

```env
OPENWEATHER_API_KEY=your_openweathermap_key
FOURSQUARE_API_KEY=your_foursquare_key
```

### 4. Start the servers

```bash
php artisan serve
npm run dev
```

### 5. Open in browser

Visit: [http://localhost](http://localhost)

---

## ✨ Why This UI/UX?

This app was designed with first-time tourists in mind:

- Mobile-first layout with touch-friendly bottom navigation
- Dark mode support improves night-time usability and accessibility
- Simplified city selector to reduce cognitive load
- Loading animations and graceful fallback for better UX
- Clean, minimal interface focused on weather and location info

---

## 📄 License

MIT — Free to use and adapt for personal or educational projects.

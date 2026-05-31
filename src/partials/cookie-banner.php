<div x-data="{shown: !localStorage.getItem('cookie_ok')}"
     x-show="shown"
     x-cloak
     class="fixed bottom-0 inset-x-0 z-40 bg-ink-900 text-white">
  <div class="container-page py-4 flex flex-col sm:flex-row items-center gap-4 text-sm">
    <p class="flex-1">We use cookies to improve your experience and analyze site traffic. By continuing you agree to our <a class="underline text-accent-500 font-semibold" href="/privacy-policy">Privacy Policy</a>.</p>
    <button @click="localStorage.setItem('cookie_ok','1'); shown=false; window.__loadGA4 && window.__loadGA4()"
            class="btn-accent text-sm !py-2.5 !px-5 whitespace-nowrap">
      Got it
    </button>
  </div>
</div>

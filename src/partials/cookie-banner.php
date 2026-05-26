<div x-data="{shown: !localStorage.getItem('cookie_ok')}"
     x-show="shown"
     x-cloak
     class="fixed bottom-0 inset-x-0 z-40 bg-navy text-white">
  <div class="container-page py-4 flex flex-col sm:flex-row items-center gap-4 text-sm">
    <p class="flex-1">We use cookies to improve your experience and analyze site traffic. By continuing you agree to our <a class="underline" href="/privacy-policy">Privacy Policy</a>.</p>
    <button @click="localStorage.setItem('cookie_ok','1'); shown=false"
            class="btn-primary text-sm py-2 px-4 whitespace-nowrap">
      Got it
    </button>
  </div>
</div>
<style>[x-cloak]{display:none!important}</style>

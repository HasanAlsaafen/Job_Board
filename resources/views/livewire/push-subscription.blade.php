<div x-data="{
    supported: 'serviceWorker' in navigator && 'PushManager' in window,
    subscribed: false,

    async init() {
        if (!this.supported) return;

        const reg = await navigator.serviceWorker.register('/sw.js');
        const sub = await reg.pushManager.getSubscription();
        this.subscribed = !!sub;
    },

    async subscribe() {
        const reg = await navigator.serviceWorker.ready;

        const sub = await reg.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: '{{ config('webpush.vapid.public_key') }}'
        });

        await $wire.saveSubscription(sub.toJSON());
        this.subscribed = true;
    }
}" x-init="init()">
    <div x-show="supported && !subscribed">
        <button @click="subscribe()" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">
            Enable Notifications
        </button>
    </div>


    <div x-show="!supported" class="text-sm text-gray-400">
        Your browser does not support notifications.
    </div>
</div>

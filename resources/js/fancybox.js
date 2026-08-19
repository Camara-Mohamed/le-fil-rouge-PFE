let fancyboxModule = null

async function ensureFancybox() {
    if (!document.querySelector('[data-fancybox]')) {
        return
    }

    if (!fancyboxModule) {
        fancyboxModule = await import('@fancyapps/ui')
    }

    fancyboxModule.Fancybox.bind('[data-fancybox]')
}

export const Fancy = {
    appFancyBox() {
        ensureFancybox()

        document.addEventListener('livewire:init', () => {
            document.addEventListener('livewire:navigated', ensureFancybox)
            document.addEventListener('livewire:updated', ensureFancybox)
        })
    }
}

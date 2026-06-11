import {Fancybox} from '@fancyapps/ui'

export const Fancy = {
    appFancyBox() {
        Fancybox.bind('[data-fancybox]')

        document.addEventListener('livewire:init', () => {
            document.addEventListener('livewire:navigated', () => {
                Fancybox.bind('[data-fancybox]')
            })

            document.addEventListener('livewire:updated', () => {
                Fancybox.bind('[data-fancybox]')
            })
        })
    }
}

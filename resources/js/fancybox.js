import {Fancybox} from '@fancyapps/ui'
import '@fancyapps/ui/dist/fancybox/fancybox.css'

export function appFancyBox() {
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

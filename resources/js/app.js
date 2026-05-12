import Alpine from 'alpinejs'
import { Fancybox } from '@fancyapps/ui'
import '@fancyapps/ui/dist/fancybox/fancybox.css'

window.Alpine = Alpine

Alpine.start()

Fancybox.bind('[data-fancybox]')

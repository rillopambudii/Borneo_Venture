import intersect from '@alpinejs/intersect'
import confetti from 'canvas-confetti'

window.confetti = confetti

document.addEventListener('alpine:init', () => {
    Alpine.plugin(intersect)
})

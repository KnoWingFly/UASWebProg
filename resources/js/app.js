import './bootstrap';
import 'flowbite';

// resources/js/app.js
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollToPlugin } from 'gsap/ScrollToPlugin';
import { MotionPathPlugin } from 'gsap/MotionPathPlugin';

// Make GSAP globally available
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
window.ScrollToPlugin = ScrollToPlugin;
window.MotionPathPlugin = MotionPathPlugin;

// Register plugins
gsap.registerPlugin(ScrollTrigger, ScrollToPlugin, MotionPathPlugin);
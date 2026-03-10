// uno.config.ts
import { defineConfig } from 'unocss'

// https://unocss.dev/presets/wind
import presetWind from '@unocss/preset-wind3'

// https://unocss.dev/transformers/directives
import transformerDirectives from '@unocss/transformer-directives'

// https://github.com/Julien-R44/unocss-preset-forms
// https://gist.github.com/imsus/3d7227b51962d6f8c01e6f187ec6fb61
// import { presetForms } from '@julr/unocss-preset-forms'

export default defineConfig({
  presets: [
    presetWind(),
    // presetForms(),
  ],

  transformers: [
    transformerDirectives(),
  ],

  // https://unocss.dev/config/theme#extendtheme
  extendTheme: (theme) => {
    theme.screens = {
      '3xl': '2160px',
    }
  },

  // https://unocss.dev/config/theme
  theme: {
    // https://unocss.dev/config/theme#breakpoints
    // https://windicss.org/guide/configuration.html#example-configuration
    breakpoints: {
      'sm': '640px',
      'md': '768px',
      'lg': '1024px',
      'xl': '1280px',
      '2xl': '1536px',
      '3xl': '2160px',
    },

    // https://tailwindcss.com/docs/font-family
    fontFamily: {
      'sans': ['DM Sans', 'sans-serif'],
      'serif': ['Ramillas', 'serif'],
    },

    // https://stackoverflow.com/questions/73888700/tailwind-css-text-size-property-overriding-line-height
    // The second attribute in the array is the default line-height value.
    fontSize: {
      // sm: '0.8rem',
      // base: '1rem',
      // xl: '1.25rem',
      // '2xl': '1.563rem',
      '3xl': ['1.775rem', '2.175rem'],
      '10xl': '9rem',
      '12xl': '12rem',
      '15xl': '14rem',
      '16xl': '15rem',
      '17xl': '16rem',
      '20xl': '18rem',
    },
    colors: {
      // transparent: 'transparent',
      // current: 'currentColor',
      'lime-light': '#e8efeb',
      'gray-dark': '#080808', 
      'gray-light': '#b3b3b3', 
    },
    width: {
      half: '50%', // usage: w-half
    },
    spacing: {
      // Won't work. Possibly a bug. use fraction instead, e.g: p-8/100
      // https://github.com/windicss/windicss/issues/415#event-5127498612
      '80%': '80%',
      '10%': '10%',
      '5%': '5%'
    },

    // https://v2.tailwindcss.com/docs/transform-origin#customizing
    transformOrigin: {
     '0': '0 0'
    },

    // https://tailwindcss.com/docs/background-size#customizing-your-theme
    // Does not work!
    backgroundSize: {
      '100/100': '100%',
      '110/100': '110%',
      '70': '200%'
    },

    // https://tailwindcss.com/docs/border-radius#customizing-your-theme
    borderRadius: {
      '4xl': '2em',
    },

    // https://tailwindcss.com/docs/aspect-ratio#using-custom-values
    aspectRatio: {
      '4/3': '4 / 3'
    },
  },

  // https://tailwindcss.com/docs/content-configuration#safelisting-classes
  // https://windicss.org/guide/extractions.html#safelist
  safelist: [
    'opacity-0',
    'opacity-100',
    '[&>_span]:!invisible',
    '!text-blue-regular',
    'translate-y-0',
    // {
    //   pattern: /bg-(red|green|blue)-(100|200|300)/,
    // },
  ]
})

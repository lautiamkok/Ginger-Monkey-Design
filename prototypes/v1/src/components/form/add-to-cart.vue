<template>
  <slot
    v-bind:submitForm="submitForm"
    v-bind:response="response"
    v-bind:increment="increment"
    v-bind:decrement="decrement"
    v-bind:checkOnInput="checkOnInput"
    v-bind:qty="qty"
  >
  </slot>
</template>

<script setup>
import { ref, reactive } from 'vue'
import useFetch from '@/composables/use-fetch'
import delay from '@/utils/delay' 

const form = reactive({
  quantity: ''
})

const response = reactive({
  status: '',
  message: ''
})

// Define props.
const props = defineProps({
  nonce: {
    type: String,
    default: ''
  },
  productId: {
    type: String,
    default: ''
  },
  apiAddToCart: {
    type: String,
    default: ''
  },
  redirectUrl: {
    type: String,
    default: ''
  },
  quantity: {
    type: [String, Number],
    default: ''
  },
  min: {
    type: [String, Number],
    default: ''
  },
  max: {
    type: [String, Number],
    default: 1
  }
})

const qty = ref(props.quantity)

async function submitForm () {
  // Validate form.
  if (!qty.value) {
    response.status = 'error'
    response.message = `The minimum order quantity for is ${props.min}.`
    return
  }

  if (qty.value > props.max) {
    response.status = 'error'
    response.message = `You can't add more than ${props.max} to the cart.`
    return 
  }

  if (props.quantity !== qty.value) {

    // Remove the class name to show a loading layer.
    const wait = document.getElementById('wait')
    wait.classList.remove('hidden')

    const form = {
      id: props.productId,
      quantity: qty.value
    }

    // Inject the contact to the database.
    // https://github.com/woocommerce/woocommerce-blocks/tree/trunk/src/StoreApi
    // https://github.com/woocommerce/woocommerce-blocks/blob/trunk/src/StoreApi/docs/cart.md#add-item
    const { data:inject } = await useFetch(props.apiAddToCart, {
      method: 'POST',
      body: JSON.stringify(form),
      headers: {
        'Content-type': 'application/json; charset=UTF-8',
        'Nonce': props.nonce
      },
    })

    // Dummy responses.
    // const inject = {
    //   status: 201,
    //   message: 'Thank you!'
    // }

    // Wait for 1 second.
    await delay(1000)

    // Add the hide class back.
    // wait.classList.add('hidden')

    if (inject.statusCode ===  201) { // 201 Created
      response.status = 'ok'
      response.message = `Added to the cart.`
    } else {
      // Remove the wait layer.
      wait.classList.add('hidden')

      response.status = 'error'
      response.message = `Can't add to the cart. Please try again or contact us.`
      return
    }

    // Reset form.
    if (inject.statusCode ===  201) { // 201 Created
      // Reset form properties.
      qty.value = ''
    } 

    // If path is set, then redirect.
    if (props.redirectUrl !== '') {
      window.location.replace(props.redirectUrl)
    }
  }
}

function resetResponse () {
  response.status = null
  response.message = null
}

function checkOnInput (event) {
  // Reset response.
  response.status = ''
  response.message = ''

  const target = event.target
  if (!target.value) {
    return
  }

  const quantity = parseInt(target.value)

  if (quantity > props.max) {
    qty.value = quantity

    response.status = 'error'
    response.message = `You can't add more than ${props.max} to the cart.`
    return 
  }

  if (quantity < props.min) {
    response.status = 'error'
    response.message = `The minimum order quantity for is ${props.min}.`
    return 
  }
  qty.value = quantity
}

function increment () {
  // Reset response.
  response.status = ''
  response.message = ''

  if (qty.value + 1 > props.max) {
    response.status = 'error'
    response.message = `You can't add more to the cart.`
    return 
  }
  qty.value++
}

function decrement () {
  // Reset response.
  response.status = ''
  response.message = ''

  if (qty.value - 1 < props.min) {
    response.status = 'error'
    response.message = `The minimum order quantity for is ${props.min}.`
    return 
  }
  qty.value--
}

</script>

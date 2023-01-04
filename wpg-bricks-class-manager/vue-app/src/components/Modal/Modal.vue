<template>
  <transition name="modal-animation">
    <div

        class="modal flex min-h-screen w-screen bg-black bg-opacity-20 justify-items-center justify-center items-center fixed inset-0" v-show="modalActive">
      <transition name="modal-animation-inner">
        <div class="modal-inner bg-gray-100 p-4" v-show="modalActive">
          <slot/>
        </div>
      </transition>
    </div>
  </transition>
</template>

<script>
export default {
  name: "Modal",
  props:{
    "modalActive": Boolean
  },
  setup(props, {emit}){
    const close = () => {
      emit("close");
    }

    return{
      close
    }
  }
}
</script>

<style scoped>
.modal-animation-enter-active{
  transition: opacity 0.3s ease-out;
}
.modal-animation-leave-active{
  transition: opacity 0.5s ease-in;
}
.modal-animation-inner-enter-active{
  transition: opacity 0.3s ease-out;
}
.modal-animation-inner-leave-active{
  transition: opacity 0.5s ease-in;
}
</style>
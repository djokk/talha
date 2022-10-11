<template>
  <div id="app">
    <component :is="layout">
      <router-view/>
    </component>
  </div>
</template>

<script>
export default {
  computed: {
    layout() {
      const layoutName = this.$route.meta.layout || 'Default';
      return () => import(`@/layouts/${layoutName}.vue`)
    }
  }
}
</script>

<style lang="scss">
body {
  // background-image: url('assets/img/bg.png');
  background-size: 100% 100%;
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  transition: background .2s;
  background: #fff;
  // background: rgba(136, 136, 136, 0.05);
}
ul {
  margin: 0;
  padding: 0;
}
li {
  list-style: none;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type=number] {
  -moz-appearance: textfield;
}
// p {
//   margin: 0;
// }
// a, a:hover {
//   outline: none;
// }
@font-face {
  font-family: 'Roboto';
  src: local('Roboto'), url('./assets/fonts/Roboto/Roboto-Thin.ttf') format('truetype');
  font-weight: 100;
}
@font-face {
  font-family: 'Roboto';
  src: local('Roboto'), url('./assets/fonts/Roboto/Roboto-Light.ttf') format('truetype');
  font-weight: 300;
}
@font-face {
  font-family: 'Roboto';
  src: local('Roboto'), url('./assets/fonts/Roboto/Roboto-Regular.ttf') format('truetype');
  font-weight: 400;
}
@font-face {
  font-family: 'Roboto';
  src: local('Roboto'), url('./assets/fonts/Roboto/Roboto-Medium.ttf') format('truetype');
  font-weight: 500;
}
@font-face {
  font-family: 'Roboto';
  src: local('Roboto'), url('./assets/fonts/Roboto/Roboto-Bold.ttf') format('truetype');
  font-weight: 600;
}
@font-face {
  font-family: 'Roboto';
  src: local('Roboto'), url('./assets/fonts/Roboto/Roboto-Black.ttf') format('truetype');
  font-weight: 700;
}

.nested-enter-active, .nested-leave-active {
	transition: all 0.2s ease-in-out;
}
/* delay leave of parent element */
.nested-leave-active {
  transition-delay: 0s;
}
.nested-enter-from,
.nested-leave-to {
  transform: translateY(30px);
  opacity: 0;
}

::-webkit-scrollbar { 
  width: 10px;
  height: 10px;
  // transition: 0.3s ease-in-out;
  // &:hover{
  //   width: 12px;
  //   // height: 100%;
  // }
}
// ::-webkit-scrollbar-button {  background-color: #666; }
// ::-webkit-scrollbar-track {  background-color: #999;}
::-webkit-scrollbar-track-piece { background-color: #dfe3e7;}
::-webkit-scrollbar-thumb { height: 50px; background-color: rgb(1, 40, 65); border-radius: 0px;}
::-webkit-scrollbar-corner { background-color: rgb(1, 40, 65);}
::-webkit-resizer { background-color: rgb(1, 40, 65);}
::-webkit-scrollbar-thumb:hover {
  background-color: #002F34;
  &::-webkit-scrollbar {
    width: 12px;
  }
}
</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

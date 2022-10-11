<template>
    <div v-if="activeLogout" class="logout">
  <!-- <transition name="bounce"> -->
      <div class="logout__content">
        <h1>{{ $t('textLogout') }}</h1>
        <div class="logout__btns">
          <button @click.prevent="logoutBtn()" type="button" class="btn btn-success">{{ $t('yes') }}</button>
          <button @click.prevent="logoutClose()" type="button" class="btn btn-danger">{{ $t('not') }}</button>
        </div>
      </div>
  <!-- </transition> -->
    </div>
</template>

<script>
export default {
  // data() {
  //   return {
  //     notBtn: false
  //   }
  // },
  props: ['activeLogout'],
  methods: {
    logoutClose() {
      this.$emit("closeLogout");
    },  
    logoutBtn() {
      this.$router.push({ path: '/' });
      localStorage.clear();
      sessionStorage.clear();
    }
  }
}
</script>

<style lang="scss">

.logout {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  background: rgba($color: #000, $alpha: 0.5);
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 100;
  &__content {
    width: 280px;
    background: #fff;
    border-radius: 0.25rem;
    padding: 12px;
    // z-index: 11;
    z-index: 98;
    h1 {
      font-family: 'Roboto';
      font-size: 24px;
      font-weight: 500;
      text-align: center;
      margin-bottom: 10px;
      color: #002f34;
    }
  }
  &__btns {
    display: flex;
    justify-content: space-between;
    align-items: center;
    .btn {
      width: 48%;
      font-family: 'Roboto';
      font-size: 20px;
      font-weight: 500;
      padding: 8px 0px;
      // &:nth-child(1) {
      //   margin-right: 10px;
      // }
    }
  }
}

.bounce-enter-active {
  animation: bounce-in .4s;
}
.bounce-leave-active {
  animation: bounce-in .4s reverse;
}
@keyframes bounce-in {
  0% {
    transform: translate(-50%, -50%) scale(0);
  }
  50% {
    transform: translate(-50%, -50%) scale(1.5);
  }
  100% {
    transform: translate(-50%, -50%) scale(1);
  }
}
</style>
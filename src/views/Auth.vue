<template>
  <div class="auth">
    <div class="row">
      <div class="col-xl-6 col-lg-6 col-md-0">
        <div class="left">
          <h1 @click="localReChange()" class="title">Talha</h1>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-12">
        <div class="right">
          <h2 @click="localReChange()" class="title">Talha</h2>
          <form class="right__form form" action="#" @submit.prevent="auth()">
            <h4 class="form__title">{{ $t('entrance') }}</h4>
            <div class="form__item" :class="$v.login.$error ? 'is-invalid' : ''">
              <input v-model="login" type="text">
              <span :class="login != '' ? 'active-span' : '' ">{{ $t('login') }}</span>
            </div>
            <div class="form__item" :class="$v.password.$error ? 'is-invalid' : ''">
              <input v-model="password" type="text">
              <span :class="password != '' ? 'active-span' : '' ">{{ $t('password') }}</span>
            </div>
            <button class="btn btn-primary" type="submit">{{ $t('bntEntrance') }}</button>
          </form>
        </div>
      </div>
    </div>
    <Loading v-if="loading" />
  </div>
</template>

<script>
import axios from 'axios'
import { required, minLength } from 'vuelidate/lib/validators'
import Loading from '@/components/Loading.vue';

export default {
  name: 'Auth',
  data () {
    return {
      loading: false,
      login: '',
      password: '',
      api: ''
    }
  },
  components: {
    Loading
  },
  beforeMount() {
    this.api = window.MY_TALHA.api;
    // localStorage.setItem('local', 'ru');
  },
  mounted() {
    if (localStorage.local == 'uz' || localStorage.local == 'ru' || localStorage.local == 'en') {
      this.$i18n.locale = localStorage.local;
    } else {
      this.updateLang();
    }
  },
  methods: {
    updateLang () {
      localStorage.local = 0
      if (localStorage.local == 0) {
        localStorage.local = 'ru'
        this.$i18n.locale = 'ru'
      } else {
        this.$i18n.locale = localStorage.local
      }
    },
    auth() {
      this.$v.$touch()
      if(!this.$v.login.$invalid && !this.$v.password.$invalid) {
        this.loading = true;
        axios.post(`${this.api}/auth`, {
            'Login': this.login,
            'Password': this.password
          })
          .then((response) => {
            // console.log(response.data);
            sessionStorage.setItem('auth', JSON.stringify(response.data));
            sessionStorage.setItem('token', response.data.Token);
            if(response.data.Status == true) {
              this.$router.push({ name: 'Stores' });
            } else {
              this.$toast.error('Ввидите данные правильно');
            }
          })
          .catch(error => {
            // console.log(error);
            this.$toast.error(error);
          })
          .finally(() => {
            this.loading = false;
          });
      }
    },
    loadingAuth() {
      const auth = localStorage.getItem('auth');
      if(auth) {
        this.$router.push({ name: 'Panel' })
      }
    },
    localReChange() {
      const local = localStorage.getItem('local');
      if(local == 'uz') {
        localStorage.local = 'ru';
        this.$i18n.locale = 'ru'
      } else {
        localStorage.local = 'uz';
        this.$i18n.locale = 'uz'
      }
    }
  },
  validations: {
    login: {
      required,
      minLength: minLength(2)
    },
    password: {
      required,
      minLength: minLength(2)
    }
  },
  created() {
    if(localStorage.local == 'uz' || localStorage.local == 'ru'){
      this.$i18n.locale = localStorage.local
    }
  }
}
</script>

<style lang="scss" scoped>
.auth {
  overflow: hidden;
}
.row {
  position: relative;
  &::before {
    content: "";
    position: absolute;
    top: 0px;
    bottom: 0px;
    left: 0px;
    margin-top: -28%;
    margin-bottom: -15%;
    margin-left: -13%;
    width: 70%;
    transform: translate(0,0) rotate(-4deg) skew(0) skewY(0) scaleX(1) scaleY(1);
    border-radius: 100%;
    background-color: rgba(#002f34, .2);
    @media screen and (max-width: 1140px) {
      width: 60%;
    }
    @media screen and (max-width: 991.5px) {
      display: none;
    }
  }
  &::after {
    content: "";
    position: absolute;
    top: 0px;
    bottom: 0px;
    left: 0px;
    margin-top: -20%;
    margin-bottom: -12%;
    margin-left: -13%;
    width: 70%;
    transform: translate(0,0) rotate(-4deg) skew(0) skewY(0) scaleX(1) scaleY(1);
    border-radius: 100%;
    background-color: rgba(#002f34, 1);
    @media screen and (max-width: 1140px) {
      width: 60%;
    }
    @media screen and (max-width: 991.5px) {
      display: none;
    }
  }
}
.left {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  position: relative;
  z-index: 2;
  @media screen and (max-width: 991.5px) {
    display: none;
  }
  img {
    width: 800px;
    @media screen and (max-width: 1668px) {
      width: 500px;
    }
    @media screen and (max-width: 1140px) {
      width: 300px;
    }
  }
}
.right {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  width: 100%;
  height: 100vh;
  .form {
    width: 46%;
    padding: 0 15px;
    @media screen and (max-width: 991.5px) {
      width: 100%;
    }
    @media screen and (max-width: 1668px) {
      width: 56%;
    }
    @media screen and (max-width: 1140px) {
      width: 80%;
    }
    @media screen and (max-width: 767.5px) {
      width: 90%;
    }
    &__title {
      font-family: 'Roboto';
      font-size: 1.875rem;
      line-height: 2.25rem;
      font-weight: 600;
      // text-transform: uppercase;
      color: #000;
      // color: #296073;
      text-align: left;
      margin-bottom: 2rem;
    }
    &__item {
      position: relative;
      margin-bottom: 1rem;
      span {
        font-family: 'Roboto';
        font-size: 17px;
        font-weight: 400;
        position: absolute;
        top: 50%;
        left: 1rem;
        transform: translateY(-50%);
        color: rgba(0,0,0,.4);
      }
      input {
        width: 100%;
        font-family: 'Roboto';
        font-size: 17px;
        font-weight: 400;
        border: 1px solid rgb(226,232,240);
        // border: 2px solid rgba(0,0,0,.12);
        border-radius: 0.375rem;
        padding: 0.75rem 1rem 0.75rem;
        position: relative;
        background: transparent;
        z-index: 1;
        box-shadow: 0 0 #0000, 0 0 #0000,0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgba(0,0,0,0.05);
        &:hover {
          border-color: #002f34;
          transition: 0.3s all ease-in-out;
        }
        &:focus-visible {
          border-color: #002f34;
          outline: none;
        }
        &:focus {
          border-color: #002f34;
          // box-shadow:  0 0 0 5px rgba(22,78,99,0.2);
        }
      }
      input:focus-visible+span{
        top: 0%;
        font-size: 13px;
        background: #fff;
        color: var(--color-primary) !important;
        padding: 2px 5px;
        transition: 0.3s all ease-out;
        z-index: 2;
      }
      input:hover+span{
        color: var(--color-primary);
        // color: #296073;
      }
    }
    .active-span {
      top: 0%;
      font-size: 13px;
      background: #fff;
      color: rgba(0, 0, 0, 0.4);
      padding: 2px 5px;
      z-index: 2;
    }
    .btn {
      // width: 8rem;
      font-family: 'Roboto';
      font-size: 1rem;
      font-weight: 500;
      // text-transform: uppercase;
      background-color: #002f34;
      border: none;
      border-radius: 0.375rem;
      box-shadow: 0 0 #0000, 0 0 #0000,0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgba(0,0,0,0.05);
      padding: 0.75rem 1rem 0.75rem;
      margin-top: 1rem;
      transition: 0.3s all ease-in-out;
      &:hover {
        background-color: rgba(#002f34, 0.9);
        // background: rgba($color: rgb(22,78,99), $alpha: 0.9);
      }
    }
  }
  .title {
    color: #002f34;
    display: none;
    @media screen and (max-width: 991.5px) {
      display: block;
      font-size: 6rem;
      margin-bottom: 2rem;
    }
  }
}
.is-invalid {
  input {
    border-color: red !important;
  }
  span {
    color: red !important;
  }
}
  
.title {
  font-family: 'Roboto';
  font-size: 10rem;
  font-weight: 700;
  color: #fff;
}
</style>

<template>
  <section class="color">
    <div class="breadcrumb p-0">
      <router-link :to="{name: 'Stores'}" class="breadcrumb__link"><i class="bx bx-home-alt"></i></router-link>
      <div class="breadcrumb__item">
        <i class="fa fa-angle-right"></i>
        <p>{{ $t('stores') }}</p>
      </div>
    </div>
    <div class="wrapper">
      <div class="card-custom">
        <div class="table-custom">
          <div class="table-custom__header">
            <!-- <p class="w-4">{{ $t('date') }}</p> -->
            <p class="w-1">{{ $t('name') }}</p>
            <p class="w-2">{{ $t('code') }}</p>
            <p class="w-3">{{ $t('color') }}</p>
            <p class="w-4">{{ $t('count') }}</p>
          </div>
          <div class="table-custom__body">
            <div v-for="item in info" :key="item.id" @click="openModalStore(item)" class="table-custom__body-item">
              <!-- <p class="w-4">{{ item.Dates }}</p> -->
              <p class="w-1">{{ item.Name }}</p>
              <p class="w-2">{{ item.Code }}</p>
              <p class="w-3">{{ item.Color }} / {{ item.ColorCode }}</p>
              <p class="w-4">{{ item.Counts }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="modalAdd" class="modal-add">
      <form  @submit.prevent="editStore()" class="form" action="">
        <div class="name">
          <p><span>{{ $t('modelCode') }}:</span> {{ modelCode }}</p>
        </div>
        <div class="name">
          <p><span>{{ $t('modelName') }}:</span> {{ modelName }}</p>
        </div>
        <div class="name">
          <p><span>{{ $t('color') }}:</span> {{ modelColorValue.Name }} {{ modelColorValue.Code }}</p>
        </div>
        <div class="name">
          <p><span>{{ $t('count') }}:</span> {{ modelCountsForm > 0 ? '+' : '' }}{{ modelCountsForm }}</p>
        </div>
        <div class="count">
          <button @click.prevent="minus()" class="btn btn-left bg-danger" :disabled='btnIsDisabled'><i class='bx bx-minus'></i></button>
          <p>{{ modelCounts }}</p>
          <button @click.prevent="plus()" class="btn btn-right bg-success"><i class='bx bx-plus'></i></button>
        </div>
        <div class="btns">
          <button class="btn btn-warning" type="submit" :disabled='btnSubmitIsDisabled'>{{ $t('change') }}</button>
          <button @click.prevent="closeModal()" class="btn btn-outline-danger" type="button">{{ $t('cancel') }}</button>
        </div>
      </form>
    </div>
    <div v-show="modalAdd" class="modal-bg"></div>
    <Loading v-show="loading"/>
  </section>
</template>

<script>
import axios from 'axios';
import Loading from '@/components/Loading.vue';

export default {
  name: 'Store',
  data() {
    return {
      loading: false,
      modalAdd: false,
      btnIsDisabled: false,
      btnSubmitIsDisabled: true,
      info: [],
      token: '',
      modelId: '',
      modelName: '',
      modelCode: '',
      modelColorValue: '',
      modelColorOption: [],
      modelCounts: 0,
      modelCountsForm: 0,
      counts: 0,
      // modelDates: '',
      // modelTimes: '',
      modelParametrs: 0,
      auth: [],
      api: '',
    }
  },
  components: {
    Loading
  },
  beforeMount() {
    this.api = window.MY_TALHA.api;
    // this.token = localStorage.token;
  },
  mounted() {
    // this.token = sessionStorage.getItem('token');
    const auth = JSON.parse(sessionStorage.getItem('auth'));
    if(auth == null || auth == undefined) {
      this.$router.push({ name: 'Auth' });
    } else {
      this.auth = JSON.parse(sessionStorage.getItem('auth'));
    }
    this.$i18n.locale = localStorage.local;
    this.getStore();
    this.getColor();
  },
  methods: {
    getStore() {
      this.loading = true;
      this.info = [];
      axios.get(`${this.api}/store`)
        .then(response => {
          this.info = response.data;
        })
        .catch(error => {
          console.log(error);
          this.$toast.error(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    getColor() {
      this.loading = true;
      this.modelColorOption = [];
      axios.get(`${this.api}/color`)
        .then(response => {
          for (let index = 0; index < response.data.length; index++) {
            this.modelColorOption.push({
              Id: +response.data[index].Id,
              Name: response.data[index].Name,
              NameCode: `${response.data[index].Name} ${response.data[index].Code}`,
              Code: response.data[index].Code,
            });
          }
          // this.colorOption = response.data;
        })
        .catch(error => {
          console.log(error);
          this.$toast.error(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    minus() {
      this.modelCounts = this.modelCounts - 1;
      this.modelCountsForm = this.modelCountsForm - 1;
      this.modelParametrs = 0;
    },
    plus() {
      this.modelCounts = this.modelCounts + 1;
      this.modelCountsForm = this.modelCountsForm + 1;
      this.modelParametrs = 1;
    },
    openModalStore(item) {
      this.modelId = item.Id;
      this.modelCode = item.Code;
      this.modelName = item.Name;
      // this.colorOption = item;
      this.modelColorValue = this.modelColorOption.find(items => items.Id == item.ColorId);
      this.modelCounts = item.Counts;
      if(item.Counts == 0) {
        this.btnIsDisabled = true;
      }
      this.counts = item.Counts;
      this.modelDates = item.Dates;
      this.modelTimes = item.Times;
      this.modalAdd = true;
    },
    editStore() {
      axios.put(`${this.api}/store`, {
          "Id": this.modelId,
          "Code": this.modelCode,
          "Name": this.modelName,
          "Color": this.modelColorValue.Name,
          "ColorId": this.modelColorValue.Id,
          "ColorCode": this.modelColorValue.Code,
          "Counts": this.modelCounts,
          "CountEnd": Math.abs(this.modelCountsForm),
          "Parametrs": this.modelParametrs,
          "Login": this.auth.Login,
          "FullName": this.auth.FullName,
        })
        .then(() => {
          this.$toast.success('Изменнено');
          this.getStore();
        })
        .catch(error => {
          console.log(error);
          this.$toast.error(error);
        })
        .finally(()=> {
          this.closeModal();
          this.loading = false;
        });
    },
    closeModal() {
      this.modalAdd = false;
      this.modelId = '';
      this.modelCode = '';
      this.modelName = '';
      this.modelColorValue = '';
      this.modelCounts = '';
      this.modelDates = '';
      this.timodelTimesmes = '';
      this.modelParametrs = 0;
      this.modelCountsForm = 0;
    }
  },
  watch: {
    modelCounts() {
      if(this.modelCounts == 0) {
        this.btnIsDisabled = true;
      } else {
        this.btnIsDisabled = false;
      }
      if(this.counts != this.modelCounts) {
        this.btnSubmitIsDisabled = false;
      } else {
        this.btnSubmitIsDisabled = true;
      }
    },
    plus() {
      this.modelParametrs = 1;
    },
    minus() {
      this.modelParametrs = 0;
    }
  }
}
</script>

<style lang="scss" scoped>
.color {
  @media screen and (max-width: 991.5px) {
    margin-left: 0;
    padding: 0px 10px;
  }
  .breadcrumb {
    display: flex;
    align-items: center;
    background-color: transparent;
    margin: 0px 0 25px;
    &__item {
      display: flex;
      align-items: center;
      .fa {
        color: #002f34;
        font-size: 25px;
        margin: 0 10px;
      }
      p {
        font-family: 'Roboto';
        font-size: 18px;
        line-height: 18px;
        font-weight: 500;
        color: #002f34;
      }
    }
    &__link {
      display: flex;
      align-items: center;
      .bx {
        color: #002f34;
        font-size: 26px;
      }
    }
  }
  .card-custom {
    // position: relative;
    // display: flex;
    // flex-direction: column;
    // min-width: 0;
    // word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid transparent;
    border-radius: 0.25rem;
    margin-bottom: 4.5rem;
    box-shadow: 0 0.3rem 0.8rem rgba(0,0,0,0.12);
    padding: 1rem;
    overflow: scroll hidden;
  }
  .table-custom {
    min-width: 800px;
    // overflow: scroll hidden;
    &__header {
      display: flex;
      // justify-content: space-between;
      align-items: center;
      // padding: 0 0.5rem 1rem 0.5rem;
      p {
        font-size: 20px !important;
        font-weight: 600 !important;
        text-align: center;
        padding: 1rem;
      }
    }
    &__body {
      &-item {
        display: flex;
        transition: 0.3s all ease-in-out;
        min-height: 64px;
        padding: 0 0.5rem 0 0;
        cursor: pointer;
        &:hover {
          background: rgba($color: #002f34, $alpha: 1) !important;
          p {
            color: #fff;
          }
        }
        &:nth-child(odd) {
          background: rgba($color: #002f34, $alpha: 0.12);
        }
        &:not(:last-child){
          border-bottom: 1px solid rgba($color: #002f34, $alpha: 0.15);
        }
        p {
          display: flex;
          justify-content: center;
          align-items: center;
          // padding: 0.5rem 0.5rem;
        }
        .btns {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding-left: 0.5rem;
          .btn {
            display: block;
            padding: 0.375rem 0.75rem;
          }
        }
        .w-2 {
          border-left: 1px solid rgba(255, 255, 255, 0.15);
          border-right: 1px solid rgba(255, 255, 255, 0.15);
        }
        .w-4 {
          border-left: 1px solid rgba(255, 255, 255, 0.15);
        }
      }
    }
    p {
      font-family: 'Roboto';
      font-size: 16px;
      line-height: 16px;
      font-weight: 400;
      color: rgba($color: #002f34, $alpha: 0.85);
      word-break: break-all;
      white-space: pre-wrap;
    }
    .w-1 {
      width: calc(100%/4);
    }
    .w-2 {
      width: calc(100%/4);
    }
    .w-3 {
      width: calc(100%/4);
    }
    .w-4 {
      width: calc(100%/4);
    }
    // .w-5 {
    //   width: calc(100%/5);
    // }
  }
  .modal-add {
    position: fixed;
    z-index: 11;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    border-radius: 0.5rem;
    padding: 12px;
    .text {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid #212529;
      p {
        font-family: 'Roboto';
        font-size: 20px;
        font-weight: 400;
        cursor: pointer;
        padding: 5px 16px;
        color: rgb(129, 129, 129);
        transition: 0.3s all ease-in-out;
        &:hover {
          color: #000;
          background: rgb(230, 230, 230);
        }
      }
      .active {
        color: #fff;
        background: #212529;
        &:hover {
          color: #fff;
          background: #212529;
        }
      }
    }
    .form {
      width: 400px;
      display: flex;
      flex-direction: column;
      @media screen and (max-width: 575.5px) {
        width: 290px;
      }
      p {
        font-family: 'Roboto';
        font-size: 1.2rem;
        line-height: 1.2rem;
        margin-bottom: 10px;
        span {
          font-weight: 500;
        }
      }
      .btns {
        display: flex;
        justify-content: space-between;
        .btn {
          width: 48%;
          font-family: 'Roboto';
          padding: 8px 30px;
          text-transform: uppercase;
          @media screen and (max-width: 575.5px) {
            padding: 8px 16px;
          }
        }
      }
    }
  }
  // .selects,
  // .name {
  //   position: relative;
  //   span {
  //     position: absolute;
  //     z-index: 2;
  //     top: 0%;
  //     left: 10px;
  //     transform: translateY(-50%);
  //     font-family: 'Roboto';
  //     font-size: 12px;
  //     font-weight: 400;
  //     color: rgba(0,0,0,.4);
  //     background: #fff;
  //     padding: 2px 5px;
  //   }
  // }
  // .input {
  //   width: 100%;
  //   font-family: 'Roboto';
  //   font-size: 18px;
  //   font-weight: 400;
  //   color: #5A5A5A;
  //   border: 2px solid rgba(0,0,0,.12);
  //   border-radius: 5px;
  //   padding: 0.5em 0.7em;
  //   position: relative;
  //   background: transparent;
  //   z-index: 1;
  //   margin: 0;
  //   &:hover {
  //     border-color: rgb(175, 175, 175);
  //     transition: 0.3s all ease-in-out;
  //   }
  //   &:focus-visible {
  //     border-color: rgb(175, 175, 175);
  //     outline: none;
  //   }
  // }
  // input:focus-visible+span{
  //   transition: 0.3s all ease-in-out;
  //   color: rgb(175, 175, 175) !important;
  // }
  // input:hover+span{
  //   transition: 0.3s all ease-in-out;
  //   color: rgb(175, 175, 175);
  // }
  .modal-bg {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    position: fixed;
    top: 0;
    left: 210px;
    z-index: 10;
    @media screen and (max-width: 991.5px) {
      left: 0px;
    }
  }
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
      /* display: none; <- Crashes Chrome on hover */
      -webkit-appearance: none;
      margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
  }
  .count {
    display: flex;
    align-items: center;
    .btn {
      width: 45px;
      height: 34px;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Roboto';
      font-size: 1.5rem;
      line-height: 1.5rem;
      color: #fff;
      // background: gray;
      // padding: 5px 15px;
      border-radius: 0;
      margin-bottom: 15px;
      outline: none;
      &:focus {
        box-shadow: none;
      }
      &-left {
        border-bottom-left-radius: 10px;
        border-top-left-radius: 10px;
        // background-color: red;
      }
      &-right {
        border-bottom-right-radius: 10px;
        border-top-right-radius: 10px;
        // background-color: green;
      }
    }
    p {
      // width: 34px;
      height: 34px;
      font-family: 'Roboto';
      font-size: 1.5rem !important;
      line-height: 1.5rem !important;
      background: rgba(gray, 0.2);
      padding: 5px 10px;
      border-radius: none;
      margin-bottom: 15px !important;
    }
  }
}
</style>
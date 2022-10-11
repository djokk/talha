<template>
<div class="wrapper">
  <div class="header">
    <div class="header__sidebar-header sidebar-header" :class="[menuActive ? 'd-flex' : '']">
      <router-link :to="{name: 'Stores'}" class="sidebar-header__link-logo-title" href="">TALHA</router-link>
      <div @click="openMenu()" class="sidebar-header__close-menu">
        <i class='bx bx-x'></i>
      </div>
    </div>
    <div class="header__sidebar-left" :class="[menuActive ? 'd-block' : '']">
      <nav class="nav">
        <ul class="nav__menu menu">
          <li class="menu__item" @click.prevent="isSidebarActiveItem(1)" :class="[isActiveItem == 1 ? 'active': '']">
            <router-link :to="{name: 'Stores'}" class="menu__link" href=""><i class='bx bxs-home'></i>{{ $t('stores') }}</router-link>
          </li>
          <li class="menu__item" @click.prevent="isSidebarActiveItem(2)" :class="[isActiveItem == 2 ? 'active': '']">
            <router-link :to="{name: 'Add'}" class="menu__link" href=""><i class='bx bxs-layer-plus'></i>{{ $t('add') }}</router-link>
          </li>
          <li class="menu__item" @click.prevent="isSidebarActiveItem(3)" :class="[isActiveItem == 3 ? 'active': '']">
            <router-link :to="{ name: 'History'}" class="menu__link"><i class='bx bxs-food-menu'></i>{{ $t('history') }}</router-link>
          </li>
          <li class="menu__item">
            <button class="menu__btn" @click="removeLogout()">{{ $t('btnExit') }}</button>
          </li>
        </ul>
      </nav>
    </div>
    <div class="header__top">
      <div @click="openMenu()" class="btn-burger">
        <i class='bx bx-menu'></i>
      </div>
      <!-- <div class="account">
        <div class="account__text">
          <p class="account__title">Jakhongir</p>
          <p class="account__subtitle">Admin</p>
        </div>
        <img class="account__img" src="/img/account.png" alt="">
      </div> -->
    </div>
  </div>
  <!-- MAIN CONTENT -->
  <div class="main-wrapper">
    <slot/>
  </div>
  <!-- END MAIN CONTENT -->
  <Logout :activeLogout="logout" @closeLogout="removeLogout()"/>
  <div v-show="bgLogout" @click="openMenu()" class="logout-bg"></div>
</div>
</template>

<script>
import Logout from '@/components/Logout.vue'

export default {
  data() {
    return {
      isActiveItem: 1,
      bgLogout: false,
      logout: false,
      menuActive: false,
      menu: []
    }
  },
  components: {
    Logout
  },
  beforeMount() {
    this.loadPath();
  },
  mounted() {  
    this.$i18n.locale = localStorage.local;
  },
  methods: {
    isSidebarActiveItem(id) {
      if(this.isActiveItem == id) {
        this.isActiveItem = 0;
      } else {
        this.isActiveItem = id;
      }
    },
    loadPath() {
      switch (this.$route.name) {
        case "Dashboard":
          this.isActiveItem = 1;
          break;
        case "Add":
          this.isActiveItem = 2;
          break;
        case "Colors":
          this.isActiveItem = 2;
          break;
        case "Models":
          this.isActiveItem = 2;
          break;
        case "Users":
          this.isActiveItem = 2;
          break;
        case "History":
          this.isActiveItem = 3;
          break;
      }
    },
    removeLogout() {
      this.logout = !this.logout;
      // this.logout = false;
      this.menuActive = !this.menuActive;
    },
    openMenu() {
      this.bgLogout = !this.bgLogout;
      this.menuActive = !this.menuActive;
    }
  }
}
</script>

<style lang="scss">
.header {
  height: 100%;
  background: rgba(0,0,0,0.15);
  .sidebar-header {
    width: 210px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 0.5rem;
    background: #fbfaff;
    padding: 0;
    margin: 0;
    list-style: none;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 99;
    @media screen and (max-width: 991.5px) {
      justify-content: space-between;
      display: none;
    }
    &__link-logo-title {
      display: inline-block;
      width: 100%;
      padding: 8px;
      font-family: 'Roboto';
      font-size: 30px;
      line-height: 30px;
      font-weight: 700;
      color: #002f34;
      text-align: center;
      outline: none;
      @media screen and (max-width: 991.5px) {
        padding: 8px 0 8px 8px;
      }
    }
    &__close-menu {
      cursor: pointer;
      display: none;
      height: 46px;
      padding: 8px;
      
      @media screen and (max-width: 991.5px) {
        display: block;
      }
      .bx {
        font-weight: 900;
        font-size: 30px;
        color: red;
      }
    }
  }
  &__sidebar-left {
    width: 210px;
    height: 100%;
    background: #fbfaff;
    position: fixed;
    top: 46px;
    left: 0;
    z-index: 99;
    // width: 280px;
    overflow: hidden auto;
    padding-bottom: 50px;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    @media screen and (max-width: 991.5px) {
      display: none;
    }
    .nav {
      .menu {
        width: 100%;
        height: 100%;
        background: #fbfaff;
        padding: 0;
        margin: 0;
        &__item {
          cursor: pointer;
          margin-bottom: 2px;
          &:nth-last-child(1) {
            padding: 0 10px;
          }
          .dropdown-list {
            opacity: 0;
            max-height: 0;
            transition: all 0.3s ease-out;
            border-bottom: 1px solid #002f34;
            // margin-bottom: 10px;
            &__link {
              position: relative;
              display: flex;
              align-items: center;
              justify-content: left;
              padding: 10px 15px 10px 15px;
              font-family: 'Roboto';
              font-size: 15px;
              font-weight: 500;
              color: #545a6d;
              outline-width: 0;
              text-overflow: ellipsis;
              overflow: hidden;
              letter-spacing: .5px;
              transition: all .3s ease-out;
              &:hover {
                color: #002f34;
                text-decoration: none;
                // background: rgba(0,0,0,0.15);
                padding-left: 20px;
              }
              i {
                margin-right: 10px;
                color: #002f34;
              }
            }
            .active {
              color: #002f34;
              text-decoration: none;
              background: rgba($color: #002f34, $alpha: 0.05);
              
              .bx {
                color: red;
              }
            }
          }
        }
        .show {
          opacity: 1;
          max-height: 1000px;
        }
        &__item.active > .menu__link {
          color: #002f34;
          font-weight: 500;
          background: rgba($color: #002f34, $alpha: 0.1);
          // background: rgba($color: #545a6d, $alpha: 0.1);
          &::before {
            background: #002f34;
          }
        }
        &__link {
          display: flex;
          align-items: center;
          font-family: 'Roboto';
          font-size: 20px;
          line-height: 20px;
          font-weight: 400;
          color: #545a6d;
          text-decoration: none;
          padding: 0.75rem 0.75rem 0.75rem 1.5rem;
          // padding: 1rem 0.75rem 1rem 1.5rem;
          transition: 0.1s all ease-in-out;
          position: relative;
          &::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            background: transparent;
            width: 5px;
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
          }
          &:hover {
            color: #fff;
            background: #002f34;
            // background: rgba($color: #386979, $alpha: 0.5);
            font-weight: 500;
          }
          .bx, .fa {
            font-size: 20px;
            margin-right: 10px;
          }
          .bx-chevron-down {
            font-size: 30px;
            top: 50%;
            right: 0.75rem;
            position: absolute;
            margin: 0;
            transform: translateY(-50%);
          }
        }
        .list {
          // height: 0;
          // opacity: 0;
          height: 100%;
          &__item {
            margin-bottom: 2px;
            padding-left: 20px;
          }
          &__link {
            display: flex;
            align-items: center;
            font-family: 'Roboto';
            font-size: 20px;
            line-height: 20px;
            font-weight: 400;
            color: #545a6d;
            text-decoration: none;
            padding: 1rem 0.75rem 1rem 1.5rem;
            transition: 0.1s all ease-in-out;
          }
          // &__active {
            
          // }
        }
        &__btn {
          cursor: pointer;
          width: 100%;
          font-family: 'Roboto';
          font-size: 15px;
          font-weight: 500;
          color: #fff;
          background: #002f34;
          padding: 0.75rem;
          border: none;
          transition: all .3s ease-out;
          margin-top: 25px;
          border-radius: 30px;
          &:hover {
            // color: #fff;
            background: red;
            text-decoration: none;
          }
          &:focus {
            outline: none;
          }
        }
      }
    }
  }
  &__top {
    // width: calc(100vw - 220px);
    width: calc(100% - 210px);
    // display: flex;
    // justify-content: right;
    // align-items: center;
    background: #002f34;
    margin-left: 210px;
    padding: 5px 15px;
    position: fixed;
    top: 0;
    left: 0px;
    z-index: 98;
    display: none;
    // height: 36px;
    cursor: pointer;
    @media screen and (max-width: 991.5px) {
      display: block;
    }
    @media screen and (max-width: 991.5px) {
      width: 100%;
      justify-content: space-between;
      margin-left: 0px;
    }
    .btn-burger {
      display: none;
      height: 36px;
      cursor: pointer;
      @media screen and (max-width: 991.5px) {
        display: block;
      }
      .bx {
        font-size: 36px;
        color: #fff;
      }
    }
    // .account {
    //   display: flex;
    //   align-items: center;
    //   padding: 3px 0;
      
    //   &__text {
    //     display: flex;
    //     flex-direction: column;
    //     justify-content: space-between;
    //     color: #fff;
    //     margin-right: 8px;
    //   }
    //   &__title {
    //     font-family: 'Roboto';
    //     font-size: 12px;
    //     line-height: 12px;
    //     font-weight: 400;
    //     color: #fff;
    //   }
    //   &__subtitle {
    //     font-family: 'Roboto';
    //     font-size: 10px;
    //     line-height: 10px;
    //     font-weight: 400;
    //     color: rgb(219, 219, 219);
    //   }
    //   &__img {
    //     width: 30px;
    //   }
    // }
  }
}
.logout-bg {
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.3);
  position: fixed;
  top: 0;
  left: 0px;
  // left: 210px;
  z-index: 10;
}
.sidebar-left {
  margin-top: 60px;
  position: fixed;
  // overflow-y: auto;
}
.main-wrapper {
  padding: 56px 15px 0 225px;
  // padding: 60px 0 0 250px;
  @media screen and (max-width: 991.5px) {
    padding: 56px 0px 0 0px;
  }
}
</style>

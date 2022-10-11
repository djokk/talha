import Vue from 'vue'
import Vuei18n from 'vue-i18n'
// import theJson from '@/static/settings.json'

Vue.use(Vuei18n)


export default new Vuei18n({
  locale: ['uz', 'ru'],
  fallbackLocale: localStorage.local,
  messages: {
    uz: {
      local: 'uz',
      entrance: 'Kirish',
      bntEntrance: 'Tizimga kirish',
      login: 'Login',
      password: 'Parol',
      btnEntrance: 'Tizimga kirish',
      textLogout: 'Tizimdan chiqmoqchimisz ?',
      yes: 'HA',
      not: 'YOQ',
      add: 'Qoshish',
      model: 'Model',
      color: 'Rang',
      code: 'Kod',
      name: 'Nomi',
      btnExit: 'CHIQISH',
      textDelete: 'Haqiqatan ham oʻchirib tashlamoqchimisiz?',
      codeColor: 'Rang kodi',
      codeColorName: 'Rang nomi',
      stores: 'Omborhona',
      cancel: 'Bekor qilish',
      change: "O'zgartirish",
      history: 'Tarix',
      date: 'Sana',
      time: 'Vaqt',
      count: 'Soni',
      modelCode: 'Model kodi',
      modelName: 'Model nomi',
      user: 'Foydalanuvchi',
      userName: 'Foydalanuvching ismi',
    },
    ru: {
      local: 'ru',
      entrance: 'Вход',
      bntEntrance: 'Вход в систему',
      login: 'Логин',
      password: 'Пароль',
      btnEntrance: 'Вход в систему',
      textLogout: 'Выйти ?',
      yes: 'ДА',
      not: 'НЕТ',
      add: 'Добавить',
      model: 'Модель',
      color: 'Цвет',
      code: 'Код',
      name: 'Название',
      btnExit: 'ВЫХОД',
      textDelete: 'Вы уверенны что хотите удалить ?',
      codeColor: 'Код цвета',
      codeColorName: 'Название цвета',
      stores: 'Склад',
      cancel: 'Отмена',
      change: 'Изменить',
      history: 'История',
      date: 'Дата',
      time: 'Время',
      count: 'Кол-во',
      modelCode: 'Код моделя',
      modelName: 'Наз. моделя',
      user: 'Пользователь',
      userName: 'Имя пользователя',
    },
  },
  silentFallbackWarn: true,
  silentTranslationWarn: true
})
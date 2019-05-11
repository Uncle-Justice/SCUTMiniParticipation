// pages/my/my.js

const app = getApp()

Page({


  data: {
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo')
  },

  onLoad: function(options) {

    if (app.globalData.userInfo) {
      this.setData({
        userInfo: app.globalData.userInfo,
        hasUserInfo: true
      })
    } else if (this.data.canIUse) {
      // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
      // 所以此处加入 callback 以防止这种情况
      app.userInfoReadyCallback = res => {
        this.setData({
          userInfo: res.userInfo,
          hasUserInfo: true
        })
      }
    } else {
      // 在没有 open-type=getUserInfo 版本的兼容处理
      wx.getUserInfo({
        success: res => {
          app.globalData.userInfo = res.userInfo
          this.setData({
            userInfo: res.userInfo,
            hasUserInfo: true
          })
        }
      })
    }


  },
  getUserInfo: function(e) {
    console.log(e)
    app.globalData.userInfo = e.detail.userInfo
    this.setData({
      userInfo: e.detail.userInfo,
      hasUserInfo: true
    })
  },

  onManagerTap: function() {
    wx.navigateTo({
      url: '../lauch_allact/lauch_allact',
      success: function(res) {},
      fail: function(res) {},
      complete: function(res) {},
    })
  },

  onAboutTap: function(e) {
    wx.showModal({
      title: '关于',
      content: "这是一个帮助校园活动更方便地管理报名与通知的小程序。\r\n\r\n如果你有任何的建议，意见或合作意向，请联系879292889@qq.com\r\n\r\n\r\n来自华南理工大学2017软件工程中澳班的四个菜鸡：\r\n彭万山\r\n陈思源\r\n梁永辉\r\n倪成文\r\n peace&pswnmsl",
      confirmText: '明辨笃行',
      showCancel: false,
      success: function(res) {
        if (res.confirm) {
          console.log('用户点击确定')
        } else if (res.cancel) {
          console.log('用户点击取消')
        }
      }
    })
  },

  onReady: function() {

  },

  onShareAppMessage: function(options) {
    app._onShareAppMessage(options)
  }
})
var baseUrl = 'https://uncle-justice.top/zerg/public/index.php/api/v1';

App({
  onLaunch: function() {
    // 展示本地存储能力
    var logs = wx.getStorageSync('logs') || []
    // console.log('logs的值是：' + logs)
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)
    // 登录
    wx.login({
      success: res => {
        // 发送 res.code 到后台换取 openId, sessionKey, unionId
      }
    })
    // 获取用户信息
    wx.getSetting({
      success: res => {
        if (res.authSetting['scope.userInfo']) {
          // 已经授权，可以直接调用 getUserInfo 获取头像昵称，不会弹框
          wx.getUserInfo({
            success: res => {
              // 可以将 res 发送给后台解码出 unionId
              this.globalData.userInfo = res.userInfo

              // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
              // 所以此处加入 callback 以防止这种情况
              if (this.userInfoReadyCallback) {
                this.userInfoReadyCallback(res)
              }
            }
          })
        }
      }
    })

    this.getToken();
  },

  globalData: {

    userInfo: null,
    totalNoreadNum: null,
  },

  onShow: function() {
    var url = baseUrl + '/getnotification';
    this._loadNoreadNum(url);
    this.getToken();
  },


  getToken: function() {
    //调用登录接口
    wx.login({
      success: function(res) {
        var code = res.code;
        console.log('code');
        console.log(code);
        wx.request({
          url: baseUrl + '/token/user',
          data: {
            code: code
          },
          method: 'POST',
          success: function(res) {
            console.log(res.data)
            var jsonStr = res.data;
            // jsonStr = jsonStr.replace(" ", "");
            // if (typeof jsonStr != 'object') {
            //   jsonStr = jsonStr.replace(/\ufeff/g, ""); //重点
            //   var jj = JSON.parse(jsonStr);
            //   res.data = jj;
            // }

            // if (res.data.status == 1) {
            //   console.log("ok")
            // }
            wx.setStorageSync('token', res.data.token);
          },
          fail: function(res) {
            console.log(res.data);
          }
        })
      }
    })
  },



  _loadNoreadNum: function(url) {
    var that = this;
    wx.request({
      url: url,
      method: 'GET',
      header: {
        "Content-Type": "application/json",
        'token': wx.getStorageSync('token')
      },
      success: function(res) {
        var mine = res.data.total;
        that.globalData.totalNoreadNum = mine;
      },
      // 断网，打不开等情况才走fail
      fail: function(res) {
        console.log('failed')
      },
    })
  },

  _showNoreadNum: function(num) {
    if (!(num == 0 || num == null)) {
      var num = String(num);
      wx.setTabBarBadge({
        index: 2,
        text: num,
      })
    } else if (num == 0) {
      wx.removeTabBarBadge({
        index: 2,
      })
    }
  },

  _onShareAppMessage: function(options) {

    var that = this;　　 // 设置菜单中的转发按钮触发转发事件时的转发内容

    var shareObj = {
      // title: "转发的标题", // 默认是小程序的名称(可以写slogan等)
      　　　　path: '/pages/post/post', // 默认是当前页面，必须是以‘/’开头的完整路径
      imgUrl: '', //自定义图片路径，可以是本地文件路径、代码包文件路径或者网络图片路径，支持PNG及JPG，不传入 imageUrl 则使用默认截图。显示图片长宽比是 5:4
      success: function(res) {　　　　　　 // 转发成功之后的回调

        if (res.errMsg == 'shareAppMessage:ok') {　　　　　　}
      },
      fail: function() {　　　　　　 // 转发失败之后的回调

        if (res.errMsg == 'shareAppMessage:fail cancel') {　　　　　　　　 // 用户取消转发
        } else if (res.errMsg == 'shareAppMessage:fail') {　　　　　　　　 // 转发失败，其中 detail message 为详细失败信息
        }
      },
      complete: function() {　　　　　　 // 转发结束之后的回调（转发成不成功都会执行）
      }
    };　　 // 来自页面内的按钮的转发

    if (options.from == 'button') {
      var eData = options.target.dataset;
      console.log(eData.name); // shareBtn
      // 此处可以修改 shareObj 中的内容

      shareObj.path = '/pages/btnname/btnname?btn_name=' + eData.name;
    }　　 // 返回shareObj

    return shareObj;
  }


})
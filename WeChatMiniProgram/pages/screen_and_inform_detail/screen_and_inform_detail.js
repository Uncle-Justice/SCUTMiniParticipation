import {
  Screen_and_inform_detail
} from 'screen_and_inform_detail-model.js';

var screen_and_inform_detail = new Screen_and_inform_detail();
var baseUrl = 'https://uncle-justice.top/zerg/public/index.php/api/v1';

Page({

  data: {
    showModalStatus: false,
    showModalStatus2: false,
    showModalStatus3: false,
    isScreened: 0,
    loadingHidden: false,
  },

  onLoad: function(options) {
    let item = JSON.parse(options.q);
    console.log(item);
    this._loadData(item);
  },

  _loadData: function(questionnaire) {
    var q = questionnaire;

    this.setData({
      isScreened: q.approved,
      'value': {
        'id': q.id,
        'name': q.name,
        'target': '审核中',
        'detail': '',
        'notification': "notification1",
      }
    });
  },

  onShow: function() {
    this.setData({
      loadingHidden: false,
    })
  },

  powerDrawer: function(e) {
    var currentStatu = e.currentTarget.dataset.statu; //close
    this.util(currentStatu)
  },

  powerDrawer_outofwindow: function(e) {
    console.log("我点到屏幕外啦");
    var currentStatu = e.currentTarget.dataset.statu;
    this.util(currentStatu)
  },

  getDataBindTap: function(e) {
    var result = e.detail.value;
    this.setData({
      'value.target1': '审核中',
      'value.notification1': "notification1",
      'value.detail1': result,
    })
  },

  getDataBindTap2: function(e) {
    var result = e.detail.value;
    this.setData({
      'value.target2': '已录取',
      'value.notification2': "notification2",
      'value.detail2': result,
    })
  },

  getDataBindTap3: function(e) {
    var result = e.detail.value;
    this.setData({
      'value.target3': '未录取',
      'value.notification3': "notification2",
      'value.detail3': result,
    })
  },


  OnPostInformTap: function(e) {
    var currentStatu = e.currentTarget.dataset.statu;
    this.submitData();
    this.util(currentStatu);
  },

  //下面是一键筛选的内容哟！————————————————————————————————————————————————————————
  powerDrawer_outofwindow2: function(e) {
    console.log("我点到屏幕外啦");
    var currentStatu = e.currentTarget.dataset.statu;
    this.util2(currentStatu)
  },

  powerDrawer2: function(e) {
    var currentStatu = e.currentTarget.dataset.statu; //close
    this.util2(currentStatu)
  },

  OnScreenConfirmTap: function(e) {
    var currentStatu = e.currentTarget.dataset.statu;
    this.submitData2();
    this.util2(currentStatu);
  },

  //下面是部分通知的呢！——————————————————————————————————————————————————————————————————————————
  OnPartial_informTap: function(e) {
    var that = this;
    if (that.data.isScreened == 0) {
      wx.showToast({
        title: "请先进行筛选再使用此功能",
        duration: 2000,
        icon: "none",
      })
    } else {
      that.powerDrawer3(e);
    }
  },

  powerDrawer3: function(e) {
    var currentStatu = e.currentTarget.dataset.statu; //close
    this.util3(currentStatu)
  },

  powerDrawer_outofwindow3: function(e) {
    console.log("我点到屏幕外啦");
    var currentStatu = e.currentTarget.dataset.statu;
    this.util3(currentStatu)
  },

  OnPartialConfirmTap: function(e) {
    var currentStatu = e.currentTarget.dataset.statu;
    this.submitData3();
    this.util3(currentStatu);
  },
  //下面是导出表格的功能呢————————————————————————————————————————————————————————————————————

  OnDownloadTap: function() {
    // url: "https://uncle-justice.top/zerg/public/index.php/api/v1/excel"
    this.setData({
      loadingHidden: false
    })
    let _that = this;
    wx.downloadFile({
      url: 'https://uncle-justice.top/zerg/public/index.php/api/v1/excel',
      header: {
        'token': wx.getStorageSync('token')
      },
      success: function(res) {
        var filePath = res.tempFilePath;
        console.log(res)     //页面显示加载动画       
        wx.openDocument({
          filePath: filePath,
          success: function(res) {
            _that.setData({
              loadingHidden: true
            })
            console.log('打开文档成功')
          }
        })
      }
    })

  },



  //下面是调用的函数呢——————————————————————————————————————————————————————————————————————————————
  submitData: function() {
    var token = wx.getStorageSync('token');
    var that = this;
    var value = that.data.value;
    var value = {
      'id': value.id,
      'target': value.target1,
      'notification': value.notification1,
      'detail': value.detail1,
    }
    console.log(value);
    wx.request({
      url: baseUrl + '/releasenotice',
      header: {
        token: token
      },
      data: {
        'value': value
      },
      method: 'POST',
      success: function(res) {

        var already_full = res.data.already_full;

        if (already_full != 1) {
          wx.showToast({
            title: "发布成功",
            duration: 1500,
            icon: "success",
          })
        } else {
          wx.showToast({
            title: "不可重复发送全体通知!",
            duration: 2000,
            icon: "none",
          })
        }
      },
      fail: function(res) {
        console.log('操作失败');
      }

    })
  },

  submitData2: function() {
    var that = this;
    if (that.data.isScreened == 0) {


      var token = wx.getStorageSync('token');
      wx.request({
        url: baseUrl + '/approve',
        header: {
          token: token
        },
        data: {
          'value': {
            'id': this.data.value.id,
            'limit': 1
          }
        },
        method: 'POST',
        success: function(res) {
          wx.showToast({
            title: "筛选成功",
            duration: 2000,
            icon: "success",
          })

          console.log(res.data);
          var success = res.data.success;
          that.setData({
            isScreened: success,
          })
        },
        fail: function(res) {
          console.log('操作失败');
        }

      })
    } else {
      wx.showToast({
        title: "您已经筛选过了哟！",
        duration: 2000,
        icon: "none",
      })
    }
  },

  submitData3: function() {
    var token = wx.getStorageSync('token');
    var that = this;
    var value = that.data.value;
    wx.request({
      url: baseUrl + '/releasenotice',
      header: {
        token: token
      },
      data: {
        'value': {
          'id': value.id,
          'target': value.target2,
          'notification': value.notification2,
          'detail': value.detail2,
        }
      },
      method: 'POST',
      success: function(res) {},
      fail: function(res) {
        console.log('操作失败');
      }

    })

    //第二次传呢！！！————————————————————————————
    wx.request({
      url: baseUrl + '/releasenotice',
      header: {
        token: token
      },
      data: {
        'value': {
          'id': value.id,
          'target': value.target3,
          'notification': value.notification3,
          'detail': value.detail3,
        }
      },
      method: 'POST',
      success: function(res) {
        wx.showToast({
          title: "发布成功",
          duration: 1500,
          icon: "success",
        })
      },
      fail: function(res) {
        console.log('操作失败');
      }

    })
  },



  util: function(currentStatu) {
    /* 动画部分 */
    // 第1步：创建动画实例   
    var animation = wx.createAnimation({
      duration: 200, //动画时长  
      timingFunction: "linear", //线性  
      delay: 0 //0则不延迟  
    });

    // 第2步：这个动画实例赋给当前的动画实例  
    this.animation = animation;

    // 第3步：执行第一组动画  
    animation.opacity(0).rotateX(-100).step();

    // 第4步：导出动画对象赋给数据对象储存  
    this.setData({
      animationData: animation.export()
    })

    // 第5步：设置定时器到指定时候后，执行第二组动画  
    setTimeout(function() {
      // 执行第二组动画  
      animation.opacity(1).rotateX(0).step();
      // 给数据对象储存的第一组动画，更替为执行完第二组动画的动画对象  
      this.setData({
        animationData: animation
      })
      //关闭  
      if (currentStatu == "close") {
        this.setData({
          showModalStatus: false
        });
      }
    }.bind(this), 200)
    // 显示  
    if (currentStatu == "open") {
      this.setData({
        showModalStatus: true
      });
    }
  },

  util2: function(currentStatu) {
    /* 动画部分 */
    // 第1步：创建动画实例   
    var animation = wx.createAnimation({
      duration: 200, //动画时长  
      timingFunction: "linear", //线性  
      delay: 0 //0则不延迟  
    });

    // 第2步：这个动画实例赋给当前的动画实例  
    this.animation = animation;

    // 第3步：执行第一组动画  
    animation.opacity(0).rotateX(-100).step();

    // 第4步：导出动画对象赋给数据对象储存  
    this.setData({
      animationData: animation.export()
    })

    // 第5步：设置定时器到指定时候后，执行第二组动画  
    setTimeout(function() {
      // 执行第二组动画  
      animation.opacity(1).rotateX(0).step();
      // 给数据对象储存的第一组动画，更替为执行完第二组动画的动画对象  
      this.setData({
        animationData: animation
      })
      //关闭  
      if (currentStatu == "close") {
        this.setData({
          showModalStatus2: false
        });
      }
    }.bind(this), 200)
    // 显示  
    if (currentStatu == "open") {
      this.setData({
        showModalStatus2: true
      });
    }
  },

  util3: function(currentStatu) {
    /* 动画部分 */
    // 第1步：创建动画实例   
    var animation = wx.createAnimation({
      duration: 200, //动画时长  
      timingFunction: "linear", //线性  
      delay: 0 //0则不延迟  
    });

    // 第2步：这个动画实例赋给当前的动画实例  
    this.animation = animation;

    // 第3步：执行第一组动画  
    animation.opacity(0).rotateX(-100).step();

    // 第4步：导出动画对象赋给数据对象储存  
    this.setData({
      animationData: animation.export()
    })

    // 第5步：设置定时器到指定时候后，执行第二组动画  
    setTimeout(function() {
      // 执行第二组动画  
      animation.opacity(1).rotateX(0).step();
      // 给数据对象储存的第一组动画，更替为执行完第二组动画的动画对象  
      this.setData({
        animationData: animation
      })
      //关闭  
      if (currentStatu == "close") {
        this.setData({
          showModalStatus3: false
        });
      }
    }.bind(this), 200)
    // 显示  
    if (currentStatu == "open") {
      this.setData({
        showModalStatus3: true
      });
    }
  }

})
import {
  My_inform_detail
} from 'my_inform_detail-model.js';
var my_inform_detail = new My_inform_detail();
var baseUrl = 'https://uncle-justice.top/zerg/public/index.php/api/v1';

Page({
  /**
   * 页面的初始数据
   */
  data: {
    timer: '', //定时器名字
    countDownNum: '5', //倒计时初始值
    'user_checkbox': 0,
  },

  onLoad: function(options) {
    console.log(options);
    this._loadData(options);
  },

  _loadData: function(options) {
    var name = options.name;
    var id = options.id;
    var notification = options.notification;
    var alreadyread = options.alreadyread;
    var updatetime = options.updatetime;
    var alreadyreadnum = options.alreadyreadnum;
    this.setData({
      'id': id,
      'name': name,
      'notification': notification,
      'already_read': alreadyread,
      'update_time': updatetime,
      'alreadyreadnum': alreadyreadnum
    })
  },

  onShow: function() {
    //什么时候触发倒计时，就在什么地方调用这个函数
    this.countDown();
  },

  Post_bottonTap: function(options) {
    var that = this;
    var token = wx.getStorageSync('token');
    if (that.data.already_read == 0) {
      that.setData({
        'already_read': 1
      })
    }
    var id = Number(that.data.id)
    var mydatabase = {
      'id': id,
      'already_read': that.data.alreadyreadnum
    }
    console.log(mydatabase);

    wx.request({
      url: baseUrl + '/alreadyread',
      header: {
        token: token
      },
      data: {
        'value': mydatabase
      },
      method: 'POST',
      success: function(res) {
        console.log(res.data);
        wx.showToast({
          title: "已阅",
          duration: 1500,
          icon: "success",
        })
      },
      fail: function(res) {
        console.log('操作失败');
      }
    })
  },

  countDown: function() {
    let that = this;
    let countDownNum = that.data.countDownNum; //获取倒计时初始值
    //如果将定时器设置在外面，那么用户就看不到countDownNum的数值动态变化，所以要把定时器存进data里面
    that.setData({
      timer: setInterval(function() { //这里把setInterval赋值给变量名为timer的变量
        //每隔一秒countDownNum就减一，实现同步
        countDownNum--;
        //然后把countDownNum存进data，好让用户知道时间在倒计着
        that.setData({
          countDownNum: countDownNum
        })
        //在倒计时还未到0时，这中间可以做其他的事情，按项目需求来
        if (countDownNum == 0) {
          //这里特别要注意，计时器是始终一直在走的，如果你的时间为0，那么就要关掉定时器！不然相当耗性能
          //因为timer是存在data里面的，所以在关掉时，也要在data里取出后再关闭
          clearInterval(that.data.timer);
          //关闭定时器之后，可作其他处理codes go here
        }
      }, 1000)
    })
  },

  checkboxChange: function() {
    var that = this;
    if (that.data.user_checkbox == 0)
      that.setData({
        'user_checkbox': 1
      })
    else
      that.setData({
        'user_checkbox': 0
      })
  }
})
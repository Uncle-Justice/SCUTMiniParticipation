Page({
  data: {
    showModalStatus: false
  },
  onLoad: function(options) {
    // 页面初始化 options为页面跳转所带来的参数

    this.tempData();
  },
  // // 自定义弹框
  // deployed: function() {
  //   wx.navigateTo({
  //     url: '../deploy/deploy'
  //     //  url: '../logs/logs'
  //   })
  // },

  //测试临时数据
  tempData: function() {
    var list = [{
        rank: "intel酷睿5000",
        txtStyle: "",
        // icon: "/images/details/CPU.png",
        name: "CPU",
        pace: "¥151",
      }

    ]

    //
    this.setData({
      list: list
    });
  },

  // 弹框
  powerDrawer: function(e) {

    var currentStatu = e.currentTarget.dataset.statu;//close
    this.util(currentStatu)
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
        wx.showToast({
          title: '添加成功',
          icon: 'succes',
          duration: 1000,
          mask: true
        })
      }
    }.bind(this), 200)
    // 显示  
    if (currentStatu == "open") {
      this.setData({
        showModalStatus: true
      });
    }
  },

  getDataBindTap: function (e) {
    var result = e.detail.value;
    console.log(result)
  },


})
// 基类

import {
  Config
} from '../utils/config.js';


class Base {
  constructor() {
    this.baseRequestUrl = Config.restUrl;
  }

  //params是数组 当noRefetch为true时，不做未授权重试机制
  request(params) {
    var url = this.baseRequestUrl + params.url;
    if (!params.type) {
      params.type = 'GET';
    }
    wx.request({
      url: url,
      data: params.data,
      method: params.type, //http请求类型
      header: {
        'content-type': 'application/json',
        'token': wx.getStorageSync('token')
      }, //令牌需要在http的header里传递

      success: function (res) {
        
        params.sCallback && params.sCallback(res);

      },
      fail: function (res) {
        console.log(res);
      },

    })
  }

  //这个地方可以用this ，因为用箭头函数，环境变量this不会改变，但是在上面request的success里面就不能用this.

  _refetch(params) {
    var token = new Token();
    token.getTokenFromServer((token) => {
      this.request(params, true)
    })
  }


  getDataSet(event, key) {
    return event.currentTarget.dataset[key];
  }
}

export {
  Base
};
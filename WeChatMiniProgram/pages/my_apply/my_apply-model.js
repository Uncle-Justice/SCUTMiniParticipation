import {
  Base
} from '../../utils/base.js'


class My_apply extends Base {
  constructor() {
    super();
  }


  getPostData(callback) {
    var params = {
      url: "getuserquestionnaire" ,
      sCallback: function (res) {

        callback && callback(res.data);
      }
    }
    this.request(params);
  }

  getInformData(callback) {
    var params = {
      url: "getnotification",
      sCallback: function (res) {

        callback && callback(res.data);
      }
    }
    this.request(params);
  }
  
}


export {
  My_apply
}
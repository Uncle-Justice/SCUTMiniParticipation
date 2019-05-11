import {
  Base
} from '../../utils/base.js'


class My_inform extends Base {
  constructor() {
    super();
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
  My_inform
}
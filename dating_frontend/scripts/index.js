const dating_web = {};

dating_web.baseURL = "http://127.0.0.1:8000/api";

dating_web.Console = (title, values, oneValue = true) => {
    console.log('===' + title + '===');
    if(oneValue){
        console.log(values);
    }else{
        for(let i =0; i< values.length; i++){
            console.log(values[i]);
        }
    }
    console.log('===' + title + '===');
}

dating_web.getAPI = async (url) => {
    try{
        return await axios(url);
    }
    catch(error){
        dating_web.Console("Error from GET API", error);
    }
}

dating_web.postAPI = async (url, data, token = null) => {
    try{
        return await axios.post(
            url,
            data,
            { headers:{
                    'Authorization' : "Bearer " + token
                }
            }
        );
    }
    catch(error){
        dating_web.Console("Error from POST API", error);
    }
}

dating_web.loadFor = (page) => {
    eval("dating_web.load_" + page + "();");
}

dating_web.login = async (username, password) => {
    const landing_url = `${dating_web.baseURL}/login`;
    const data =  {
        "username" : username,
        "password" : password
    }
    const response_login = await dating_web.postAPI(landing_url, data);
    dating_web.Console("Testing login API", response_login.data);
    return response_login.data;
}

dating_web.signup = async (data) => {
    const landing_url = `${dating_web.baseURL}/register`;
    const response_signup = await dating_web.postAPI(landing_url, data);
    // dating_web.Console("Testing signup API", response_signup.data);
    return response_signup.data ;
}

dating_web.users = async (token) => {
    const landing_url = `${dating_web.baseURL}/interested_in`;
    const response_interested_in = await dating_web.postAPI(landing_url, "", token);
    // dating_web.Console("Testing users API", response_interested_in.data);
    return response_interested_in.data ;
}

dating_web.messages = async (data, token) => {
    const landing_url = `${dating_web.baseURL}/inbox`;
    const response_inbox = await dating_web.postAPI(landing_url, data, token);
    // dating_web.Console("Testing inbox API", response_inbox.data);
    return response_inbox.data ;
}

dating_web.send = async (data, token) => {
    const landing_url = `${dating_web.baseURL}/send`;
    const response_send = await dating_web.postAPI(landing_url, data, token);
    // dating_web.Console("Testing send API", response_send.data);
    return response_send.data ;
}

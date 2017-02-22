//
//  registerViewController.swift
//  GABS
//
//  Created by Jackie Lee on 2/14/17.
//  Copyright © 2017 Jackie Lee. All rights reserved.
//

import UIKit

class registerViewController: BaseViewController {
    let URL_SAVE_TEAM = "http://students.washington.edu/jjaclee/ios/login/userRegister.php"
    
    @IBOutlet weak var userEmailTextField: UITextField!
    @IBOutlet weak var userPasswordTextField: UITextField!
    @IBOutlet weak var retypePasswordTextField: UITextField!
    
    override func viewDidLoad()
    {
        //add hamburger menu button
        //addSlideMenuButton()
        super.viewDidLoad()
        
        // Do any additional setup after loading the view.
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    @IBAction func registerButton(_ sender: UIButton) {
        let userEmail = userEmailTextField.text;
        let userPassword = userPasswordTextField.text;
        let userRepeatPassword = retypePasswordTextField.text;
        
        //checks for empty fields
        if((userEmail?.isEmpty)! || (userPassword?.isEmpty)! || (userRepeatPassword?.isEmpty)!)
        {
            displayMyAlertMessage(userMessage: "All fields are required")
            return;
        }
        
        // checks if password matches
        if(userPassword != userRepeatPassword){
            displayMyAlertMessage(userMessage: "password must match")
            return;
            
        }
        
        guard let url = URL(string: URL_SAVE_TEAM) else {
            print("Error: cannot create URL")
            return
        }
        var urlRequest = URLRequest(url: url)
        
        
        //setting the method to post
        urlRequest.httpMethod = "POST"
        
        
        //creating the post parameter by concatenating the keys and values from text field
        let postParameters = "email="+userEmail!+"&password="+userPassword!;
        
        //adding the parameters to request body
        urlRequest.httpBody = postParameters.data(using: .utf8)
        
        
        //creating a task to send the post request
        
        let task = URLSession.shared.dataTask(with:urlRequest){
            data, response, error in
            
            if error != nil{
                print("error is \(error)")
                return;
            }
            
            //parsing the response
            do {
                //converting resonse to NSDictionary
                let myJSON =  try JSONSerialization.jsonObject(with: data!, options: .mutableContainers) as? NSDictionary
                //parsing the json
                if let parseJSON = myJSON {
                    //creating a string
                    var stat : String!
                    //getting the json response
                    stat = parseJSON["status"] as! String?
                    var msg : String!
                    msg = parseJSON["message"] as! String?
                    //printing the response
                    print(stat)
                    
                    DispatchQueue.main.async { () -> Void in
                        var myAlert = UIAlertController(title:stat,message:msg, preferredStyle: UIAlertControllerStyle.alert);
                        
                        // goes back to previous screen when pressed okay
                        let okAction = UIAlertAction(title:"ok",style:UIAlertActionStyle.default) { action in
                            if(stat == "Success"){
                                self.dismiss(animated: true, completion:nil)
                            }
                        }
                        
                        // adds okay action
                        myAlert.addAction(okAction)
                        //shows the alert
                        self.present(myAlert, animated:true, completion:nil)
                    }
                }
                
            } catch {
                print(error)
            }
            
        }
        //executing the task
        task.resume()
    }
    
    @IBAction func haveAccount(_ sender: UIButton) {
        self.dismiss(animated: true, completion:nil)
    }
    func displayMyAlertMessage(userMessage:String){
        var myAlert = UIAlertController(title:"alert",message:userMessage, preferredStyle: UIAlertControllerStyle.alert);
        
        let okAction = UIAlertAction(title:"ok",style:UIAlertActionStyle.default
            , handler:nil)
        
        myAlert.addAction(okAction)
        
        self.present(myAlert, animated:true, completion:nil)
    }
    
    /*
     // MARK: - Navigation
     
     // In a storyboard-based application, you will often want to do a little preparation before navigation
     override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
     // Get the new view controller using segue.destinationViewController.
     // Pass the selected object to the new view controller.
     }
     */
    
}

//
//  detailPinViewController.swift
//  GABS
//
//  Created by Jackie Lee on 2/20/17.
//  Copyright © 2017 Jackie Lee. All rights reserved.
//

import UIKit
import MapKit



class detailPinViewController: BaseViewController {
    var time: String = ""
    var id: Int = 0
    
    
    override func viewDidLoad()
    {
        //add hamburger menu button
       // addSlideMenuButton()
        super.viewDidLoad()
        print(time)
        print(id)
        // Do any additional setup after loading the view.
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
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

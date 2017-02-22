//
//  mapKitViewController.swift
//  GABS
//
//  Created by Jackie Lee on 2/14/17.
//  Copyright © 2017 Jackie Lee. All rights reserved.
//
// N/A
// September 23, 2016
// Updating NSURL Session Calls in swift
// Code version : N/A
// Swift 3
// https://grokswift.com/updating-nsurlsession-to-swift-3-0/

// N/A
// Captial.cocao
// Annotations and accessory views: MKPinAnnotationView
// Code version : N/A
// Swift 3
//https://www.hackingwithswift.com/read/19/3/annotations-and-accessory-views-mkpinannotationview

// Belal Khan
// August 12, 2016
// viewController
// Connecting iOS App to MySQL Database
// Code version : N/A
// PHP
// https://www.simplifiedios.net/swift-php-mysql-tutorial/

import UIKit
import MapKit

class mapKitViewController: BaseViewController, MKMapViewDelegate, CLLocationManagerDelegate {
    
    @IBOutlet weak var mapView: MKMapView!
    let manager = CLLocationManager()
    var long: [Double] = []
    var lat: [Double] = []
    var time:[String] = []
    var timer = Timer()
    var selectedAnnotation : Gunshots!
    
    override func viewDidLoad()
    {
        //add hamburger menu button
        addSlideMenuButton()
        
        super.viewDidLoad()
        manager.delegate = self
        manager.desiredAccuracy = kCLLocationAccuracyBest
        manager.requestWhenInUseAuthorization()
        manager.requestLocation()
        
        getData()
        timer = Timer.scheduledTimer(timeInterval: 60.0, target: self, selector: "getData", userInfo: nil, repeats: true)
        
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    
    func getData(){
        mapView.removeAnnotations(mapView.annotations)
        let mapEndpoint: String = "http://students.washington.edu/nguy923/GABS/shots%20data/shotdatas"
        guard let url = URL(string: mapEndpoint) else {
            print("Error: cannot create URL")
            return
        }
        
        let urlRequest = URLRequest(url: url)
        
        // set up the session
        let config = URLSessionConfiguration.default
        let session = URLSession(configuration: config)
        
        
        // make the request
        
        let task = session.dataTask(with: urlRequest) {
            (data, response, error) in
            // check for any errors
            guard error == nil else {
                print("error calling GET on /todos/1")
                print(error)
                return
            }
            // make sure we got data
            guard let responseData = data else {
                print("Error: did not receive data")
                return
            }
            // parse the result as JSON, since that's what the API provides
            do {
                guard
                    let data = try JSONSerialization.jsonObject(with: responseData, options: JSONSerialization.ReadingOptions.allowFragments) as? [String : AnyObject]
                    
                    else {
                        print("error trying to convert data to JSON")
                        return
                }
                // now we have the todo, let's just print it to prove we can access it
                print("The data is: " + data.description)
                if let arrJSON = data["ShotsData"] {
                    for index in 0...arrJSON.count-1 {
                        
                        let aObject = arrJSON[index] as! [String : AnyObject]
                        
                        self.long.append(aObject["lng"] as! Double)
                        self.lat.append(aObject["lat"] as! Double)
                        self.time.append(aObject["time"] as! String)
                        
                    }
                }
                //updates the map with markers after it recieve json code.
                self.updateMap()
                
                
                
            } catch  {
                print("error trying to convert data to JSON")
                return
            }
        }
        task.resume()
    }
    
    func updateMap(){
        DispatchQueue.main.async { () -> Void in
            for i in 0...self.long.count-1{
                let pin = Gunshots(title: "Gun Shot Detected", coordinate: CLLocationCoordinate2D(latitude: self.lat[i], longitude: self.long[i]),time: self.time[i],id:1)
                self.mapView.addAnnotation(pin)
            }
            
        }
        
    }
    
    
    func locationManager(_ manager: CLLocationManager, didUpdateLocations locations: [CLLocation]) {
        
        
        let userLocation:CLLocation = locations[0]
        
        let latitude:CLLocationDegrees = userLocation.coordinate.latitude
        
        let longitude:CLLocationDegrees = userLocation.coordinate.longitude
        
        let latDelta:CLLocationDegrees = 0.5
        
        let lonDelta:CLLocationDegrees = 0.5
        
        let span:MKCoordinateSpan = MKCoordinateSpanMake(latDelta, lonDelta)
        
        let location:CLLocationCoordinate2D = CLLocationCoordinate2DMake(latitude, longitude)
        
        let region:MKCoordinateRegion = MKCoordinateRegionMake(location, span)
        
        mapView.setRegion(region, animated: false)
        
        //blue dot doesnt work for user location so uses pins to visualize that
        let pin = Gunshots(title: "London", coordinate: CLLocationCoordinate2D(latitude: 47.6062, longitude: -122.3321),time: "Home to the 2012 Summer Olympics.", id: 1)
        mapView.addAnnotation(pin)
        
    }
    
    
    func locationManager(_ manager: CLLocationManager, didFailWithError error: NSError) {
        print(error)
    }
    
    
    
    
    //in order to make this work. i had to ctrl drag mapview to viewcontroller delegate and activate map capalities.
    func mapView(_ mapView: MKMapView, viewFor annotation: MKAnnotation) -> MKAnnotationView? {
        // 1
        let identifier = "hai"
        
        // 2
        if annotation is Gunshots {
            // 3
            var annotationView = mapView.dequeueReusableAnnotationView(withIdentifier: identifier)
            
            if annotationView == nil {
                //4
                annotationView = MKPinAnnotationView(annotation: annotation, reuseIdentifier: identifier)
                annotationView!.canShowCallout = true
                
                // 5
                let btn = UIButton(type: .detailDisclosure)
                annotationView!.rightCalloutAccessoryView = btn
            } else {
                // 6
                annotationView!.annotation = annotation
            }
            
            return annotationView
        }
        
        // 7
        return nil
    }
    
    
    func mapView(_ mapView: MKMapView, annotationView view: MKAnnotationView, calloutAccessoryControlTapped control: UIControl) {
        /*let capital = view.annotation as! Capital
         let placeName = capital.title
         let placeInfo = capital.info
         
         let ac = UIAlertController(title: placeName, message: placeInfo, preferredStyle: .alert)
         ac.addAction(UIAlertAction(title: "OK", style: .default))
         present(ac, animated: true)*/
        if control == view.rightCalloutAccessoryView {
            selectedAnnotation = view.annotation as! Gunshots!
            performSegue(withIdentifier: "detailView", sender: view)
            
        }
    }
    
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        if(segue.identifier == "detailView"){
            if let details = segue.destination as? detailPinViewController {
                details.time = selectedAnnotation.time!
                details.id = selectedAnnotation.id
                
            }
        }
    }
    
}

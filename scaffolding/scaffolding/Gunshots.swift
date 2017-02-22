//
//  Gunshots.swift
//  GABS
//
//  Created by Jackie Lee on 2/20/17.
//  Copyright © 2017 Jackie Lee. All rights reserved.
//
// N/A
// Captial.cocao
// Annotations and accessory views: MKPinAnnotationView
// Code version : N/A
// Swift 3
//https://www.hackingwithswift.com/read/19/3/annotations-and-accessory-views-mkpinannotationview

import MapKit
import UIKit

class Gunshots: NSObject, MKAnnotation {
    var title: String?
    var coordinate: CLLocationCoordinate2D
    var subtitle: String?
    var time: String?
    var id: Int
    
    init(title: String, coordinate: CLLocationCoordinate2D, time: String, id: Int) {
        self.title = title
        self.coordinate = coordinate
        self.subtitle = time
        self.time = time
        self.id = id
    }
    
}

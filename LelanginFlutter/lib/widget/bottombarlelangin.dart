import 'package:flutter/widgets.dart';
import 'package:flutter/material.dart';
import 'package:floating_bottom_navigation_bar/floating_bottom_navigation_bar.dart';
import 'dart:developer' as developer;
import 'package:lelanginaja/ui/detail.dart';
import 'package:lelanginaja/ui/history.dart';
import 'package:lelanginaja/ui/auction.dart';
import 'package:lelanginaja/ui/payment.dart';
import 'package:lelanginaja/ui/settings.dart';
import 'package:lelanginaja/ui/login.dart';
import 'package:lelanginaja/ui/register.dart';
import 'package:lelanginaja/ui/home.dart';

class BottomBarLelangin extends StatefulWidget {
  int? active;

  BottomBarLelangin({Key? key, this.active}) : super(key: key);

  @override
  State<BottomBarLelangin> createState() => _BottomBarLelanginState();
}

class _BottomBarLelanginState extends State<BottomBarLelangin> {
  @override
  Widget build(BuildContext context) {
    return FloatingNavbar(
      onTap: (int val) {
        developer.log(val.toString());
        //returns tab id which is user tapped
        if (val == 0) {
          Navigator.push(
              context, new MaterialPageRoute(builder: (context) => new Home()));
        } else if (val == 1) {
          Navigator.push(context,
              new MaterialPageRoute(builder: (context) => new Histories()));
        } else if (val == 2) {
          Navigator.push(context,
              new MaterialPageRoute(builder: (context) => new Auction()));
        } else if (val == 3) {
          Navigator.push(context,
              new MaterialPageRoute(builder: (context) => new Settings()));
        }
      },
      currentIndex: widget.active,
      backgroundColor: Color(0xFF696cff),
      items: [
        FloatingNavbarItem(icon: Icons.home, title: 'Home'),
        FloatingNavbarItem(icon: Icons.history, title: 'History'),
        FloatingNavbarItem(icon: Icons.list, title: 'Auction List'),
        FloatingNavbarItem(icon: Icons.settings, title: 'Settings'),
      ],
    );
  }
}

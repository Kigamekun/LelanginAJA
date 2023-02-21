import 'package:flutter/material.dart';
import 'package:floating_bottom_navigation_bar/floating_bottom_navigation_bar.dart';
import 'dart:developer' as developer;
import 'package:lelanginaja/ui/history.dart';
import 'package:lelanginaja/ui/auction.dart';
import 'package:lelanginaja/ui/settings.dart';
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
          Navigator.pushAndRemoveUntil(
              context,
              MaterialPageRoute(builder: (context) => const Home()),
              ModalRoute.withName('/home'));
        } else if (val == 1) {
          Navigator.pushAndRemoveUntil(
              context,
              MaterialPageRoute(builder: (context) => Histories()),
              ModalRoute.withName('/history'));
        } else if (val == 2) {
          Navigator.pushAndRemoveUntil(
              context,
              MaterialPageRoute(builder: (context) => Auction(query: '')),
              ModalRoute.withName('/auction'));
        } else if (val == 3) {
          Navigator.pushAndRemoveUntil(
              context,
              MaterialPageRoute(builder: (context) => const Settings()),
              ModalRoute.withName('/settings'));
        }
      },
      currentIndex: widget.active,
      backgroundColor: const Color(0xFF696cff),
      items: [
        FloatingNavbarItem(icon: Icons.home, title: 'Home'),
        FloatingNavbarItem(icon: Icons.history, title: 'History'),
        FloatingNavbarItem(icon: Icons.list, title: 'Auction List'),
        FloatingNavbarItem(icon: Icons.settings, title: 'Settings'),
      ],
    );
  }
}

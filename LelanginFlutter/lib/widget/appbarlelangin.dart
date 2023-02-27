import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'dart:developer' as developer;
import 'package:lelanginaja/ui/login.dart';
import 'package:lelanginaja/ui/auction.dart';
import 'package:lelanginaja/ui/register.dart';
import 'package:lelanginaja/ui/settings.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';

List list = [
  "Flutter",
  "React",
  "Ionic",
  "Xamarin",
];

class AppBarLelangin extends StatefulWidget {
  const AppBarLelangin({Key? key}) : super(key: key);

  @override
  State<AppBarLelangin> createState() => _AppBarLelanginState();
}

class _AppBarLelanginState extends State<AppBarLelangin> {
  String name = '';

  @override
  void initState() {
    super.initState();
    _loadUserData();
  }

  _loadUserData() async {
    SharedPreferences localStorage = await SharedPreferences.getInstance();
    var user = jsonDecode(localStorage.getString('user').toString());

    if (user != null) {
      setState(() {
        name = user['name'];
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Container(
          margin: const EdgeInsets.only(right: 20, left: 20),
          child: Row(
            children: [
              Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  ClipRRect(
                    borderRadius: BorderRadius.circular(8.0),
                    child: Image(
                      image: AssetImage('assets/images/icowithouttext.png'),
                      width: 25,
                    ),
                  ),
                  const SizedBox(width: 10),
                  const Text('LelanginAJA',
                      style: TextStyle(
                          color: Color(0XFF566a7f),
                          fontWeight: FontWeight.bold,
                          fontSize: 15))
                ],
              ),
              const Spacer(),
              Container(
                child: name != ''
                    ? Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          TextButton(
                            onPressed: () {
                              developer.log('In Click');
                              Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) => const Settings()));
                            },
                            child: Text(name,
                                style: const TextStyle(
                                    color: Color(0XFF566a7f),
                                    fontWeight: FontWeight.bold,
                                    fontSize: 10)),
                          ),
                        ],
                      )
                    : Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          TextButton(
                            onPressed: () {
                              developer.log('In Click');
                              Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) => const Login()));
                            },
                            child: const Text('Login',
                                style: TextStyle(
                                    color: Color(0XFF566a7f),
                                    fontWeight: FontWeight.bold,
                                    fontSize: 10)),
                          ),
                          TextButton(
                            onPressed: () {
                              developer.log('In Click');
                              Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) => const Register()));
                            },
                            child: const Text('Register',
                                style: TextStyle(
                                    color: Color(0XFF566a7f),
                                    fontWeight: FontWeight.bold,
                                    fontSize: 10)),
                          ),
                        ],
                      ),
              ),
            ],
          ),
        ),
        Container(
          padding: const EdgeInsets.all(15),
          child: TextField(
            onSubmitted: (value) {
              Navigator.push(
                  context,
                  MaterialPageRoute(
                      builder: (context) => Auction(query: value)));
            },
            decoration: const InputDecoration(
              hintText: "Search Data",
              prefixIcon: Icon(Icons.search),
              border: OutlineInputBorder(
                borderRadius: BorderRadius.all(Radius.circular(7.0)),
              ),
            ),
          ),
        )
      ],
    );
  }
}

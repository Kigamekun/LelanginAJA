import 'package:flutter/material.dart';
import 'package:http/http.dart';
import 'dart:convert';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:lelanginaja/ui/login.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:developer' as developer;
import 'package:lelanginaja/ui/home.dart';
import 'package:lelanginaja/widget/fullscreenloader.dart';

class Register extends StatefulWidget {
  const Register({super.key});

  @override
  State<Register> createState() => _RegisterState();
}

class _RegisterState extends State<Register> {
  TextEditingController emailController = TextEditingController();

  TextEditingController nameController = TextEditingController();
  TextEditingController passwordController = TextEditingController();
  TextEditingController passwordconfirmationController =
      TextEditingController();
  bool _isLoading = false;

  void register(String name, email, password, passwordconfirmation) async {
    try {
      Response response =
          await post(Uri.parse("${dotenv.env['API_URL']}/api/register"), body: {
        'name': name,
        'email': email,
        'password': password,
        'passwordconfirmation': passwordconfirmation
      });

      if (response.statusCode == 200) {
        setState(() {
          _isLoading = false;
        });
        var data = jsonDecode(response.body.toString());
        developer.log(data['access_token']);
        developer.log('Login successfully');
        SharedPreferences localStorage = await SharedPreferences.getInstance();
        localStorage.setString('token', json.encode(data['access_token']));
        localStorage.setString('user', json.encode(data['data']));
        // ignore: use_build_context_synchronously
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (context) => const Home()),
        );
      } else {
        setState(() {
          _isLoading = false;
        });
        showDialog(
            context: context,
            builder: (BuildContext context) {
              return AlertDialog(
                title: const Text("Error"),
                content: Text(jsonDecode(response.body)['message']),
                actions: [
                  ElevatedButton(
                    style: ElevatedButton.styleFrom(
                      minimumSize: const Size.fromHeight(50),
                      primary: const Color(0xFF696cff), // background
                      onPrimary: Colors.white, // foreground
                    ),
                    onPressed: () {
                      Navigator.of(context).pop();
                    },
                    child: const Text('Kembali'),
                  )
                ],
              );
            });
      }
    } catch (e) {
      setState(() {
        _isLoading = false;
      });
      developer.log(e.toString());
      showDialog(
          context: context,
          builder: (BuildContext context) {
            return AlertDialog(
              title: const Text("Error"),
              content: const Text('Data yang anda masukkan salah'),
              actions: [
                ElevatedButton(
                  style: ElevatedButton.styleFrom(
                    minimumSize: const Size.fromHeight(50),
                    primary: const Color(0xFF696cff), // background
                    onPrimary: Colors.white, // foreground
                  ),
                  onPressed: () {
                    Navigator.of(context).pop();
                  },
                  child: const Text('Kembali'),
                )
              ],
            );
          });
    }
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'LelanginAJA',
      home: Scaffold(
        resizeToAvoidBottomInset: false,
        body: Stack(
          children: [
            if (_isLoading) const FullScreenLoader(),
            Padding(
                padding: const EdgeInsets.all(10),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  crossAxisAlignment: CrossAxisAlignment.center,
                  children: <Widget>[
                    Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        ClipRRect(
                          borderRadius: BorderRadius.circular(8.0),
                          child: const Image(
                            image:
                                AssetImage('assets/images/icowithouttext.png'),
                            width: 25,
                          ),
                        ),
                        const SizedBox(width: 10),
                        const Text('LelanginAJA',
                            style: TextStyle(
                                color: Color(0XFF566a7f),
                                fontWeight: FontWeight.bold,
                                fontSize: 20))
                      ],
                    ),
                    const SizedBox(height: 50),
                    Container(
                      padding: const EdgeInsets.all(10),
                      child: TextField(
                        controller: nameController,
                        decoration: const InputDecoration(
                          border: OutlineInputBorder(),
                          labelText: 'User Name',
                        ),
                      ),
                    ),
                    Container(
                      padding: const EdgeInsets.fromLTRB(10, 10, 10, 0),
                      child: TextField(
                        controller: emailController,
                        decoration: const InputDecoration(
                          border: OutlineInputBorder(),
                          labelText: 'Email',
                        ),
                      ),
                    ),
                    Container(
                      padding: const EdgeInsets.fromLTRB(10, 10, 10, 0),
                      child: TextField(
                        obscureText: true,
                        controller: passwordController,
                        decoration: const InputDecoration(
                          border: OutlineInputBorder(),
                          labelText: 'Password',
                        ),
                      ),
                    ),
                    // ignore: prefer_const_constructors
                    Opacity(
                      opacity: 0.8,
                      child: const Padding(
                        padding: EdgeInsets.fromLTRB(10, 10, 10, 0),
                        child: Text(
                          "The password must have at least 8 characters containing uppercase and lowercase letters containing numbers and special characters",
                          style: TextStyle(
                              color: Color.fromARGB(255, 236, 72, 7),
                              fontSize: 8),
                        ),
                      ),
                    ),
                    const SizedBox(height: 10),
                    Container(
                      padding: const EdgeInsets.fromLTRB(10, 10, 10, 0),
                      child: TextField(
                        obscureText: true,
                        controller: passwordconfirmationController,
                        decoration: const InputDecoration(
                          border: OutlineInputBorder(),
                          labelText: 'Password Confirmation',
                        ),
                      ),
                    ),
                    // TextButton(
                    //   onPressed: () {
                    //     //forgot password screen
                    //   },
                    //   child: const Text(
                    //     'Forgot Password',
                    //   ),
                    // ),
                    const SizedBox(height: 10),
                    Container(
                        height: 50,
                        padding: const EdgeInsets.fromLTRB(10, 0, 10, 0),
                        child: ElevatedButton(
                          style: ElevatedButton.styleFrom(
                            minimumSize: const Size.fromHeight(50),
                            primary: const Color(0xFF696cff), // background
                            onPrimary: Colors.white, // foreground
                          ),
                          onPressed: () {
                            setState(() {
                              _isLoading = true;
                            });
                            register(
                                nameController.text,
                                emailController.text,
                                passwordController.text,
                                passwordconfirmationController.text);
                          },
                          child: const Text('Register'),
                        )),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: <Widget>[
                        const Text('Have an account?'),
                        TextButton(
                          child: const Text(
                            'Sign in',
                            style: TextStyle(fontSize: 20),
                          ),
                          onPressed: () {
                            Navigator.push(
                                context,
                                MaterialPageRoute(
                                    builder: (context) => const Login()));
                            //signup screen
                          },
                        )
                      ],
                    ),
                  ],
                )),
          ],
        ),
      ),
    );
  }
}

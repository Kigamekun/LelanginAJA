import 'dart:developer' as developer;
import 'package:flutter/material.dart';
import 'package:http/http.dart';
import 'dart:convert';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:lelanginaja/ui/register.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:lelanginaja/ui/home.dart';
import 'package:lelanginaja/widget/fullscreenloader.dart';

class Login extends StatefulWidget {
  const Login({super.key});

  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {
  TextEditingController emailController = TextEditingController();
  TextEditingController passwordController = TextEditingController();
  bool _validateEmail = false;
  bool _validatePass = false;

  bool _isLoading = false;

  void login(String email, password) async {
    try {
      Response response = await post(
          Uri.parse("${dotenv.env['API_URL']}/api/login"),
          body: {'email': email, 'password': password});

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
    } catch (e) {
      setState(() {
        _isLoading = false;
      });
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
      debugShowCheckedModeBanner: false,
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
                          child: Image(
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
                                fontSize: 30))
                      ],
                    ),
                    const SizedBox(height: 50),
                    Container(
                      padding: const EdgeInsets.all(10),
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
                            login(
                                emailController.text, passwordController.text);
                          },
                          child: const Text('Login'),
                        )),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: <Widget>[
                        const Text('Does not have account?'),
                        TextButton(
                          child: const Text(
                            'Sign up',
                            style: TextStyle(fontSize: 20),
                          ),
                          onPressed: () {
                            Navigator.push(
                                context,
                                MaterialPageRoute(
                                    builder: (context) => const Register()));
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

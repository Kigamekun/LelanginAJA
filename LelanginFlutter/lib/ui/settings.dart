import 'dart:io';

import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:lelanginaja/model/user.dart';
import 'package:lelanginaja/utils/user_preferences.dart';
import 'package:lelanginaja/widget/profile_widget.dart';
import 'package:lelanginaja/widget/appbarlelangin.dart';
import 'package:lelanginaja/ui/login.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';
import 'package:lelanginaja/widget/bottombarlelangin.dart';
import 'dart:io';
import 'dart:async';
import 'package:http/http.dart';

import 'dart:developer' as developer;
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:provider/provider.dart';
import 'package:image_picker/image_picker.dart';
import '../auth_provider.dart';
import 'package:http/http.dart' as http;
import 'package:path/path.dart' as path;
import 'package:lelanginaja/widget/fullscreenloader.dart';

class Settings extends StatefulWidget {
  const Settings({super.key});

  @override
  // ignore: library_private_types_in_public_api
  _SettingsState createState() => _SettingsState();
}

class _SettingsState extends State<Settings> {
  File? image;
  String name = '';
  String email = '';
  String thumb = '';
  bool isEdit = false;
  TextEditingController nameController = TextEditingController();
  TextEditingController emailController = TextEditingController();
  TextEditingController phoneController = TextEditingController();
  TextEditingController addressController = TextEditingController();
  TextEditingController stateController = TextEditingController();
  TextEditingController zipcodeController = TextEditingController();
  TextEditingController countryController = TextEditingController();
  bool _isLoading = false;
  final user = UserPreferences.myUser;

  @override
  void initState() {
    super.initState();
    _loadUserData();
  }

  void edit(String name, email, address, phone, state, zipcode, country) async {
    SharedPreferences localStorage = await SharedPreferences.getInstance();
    var token = jsonDecode(localStorage.getString('token').toString());
    try {
      var stream = http.ByteStream(image!.openRead().cast());
      var length = await image!.length();

      var uri = Uri.parse("${dotenv.env['API_URL']}/api/edit");

      var request = http.MultipartRequest("POST", uri);
      var multipartFile = http.MultipartFile('image', stream, length,
          filename: path.basename(image!.path));
      request.files.add(multipartFile);

      request.fields.addAll({
        'name': name,
        'email': email,
        'address': address,
        'phone': phone,
        'state': state,
        'zipcode': zipcode,
        'country': country
      });

      request.headers.addAll({
        'Content-Type': 'multipart/form-data',
        'Authorization': 'Bearer ' + token
      });

      var response = await request.send();
      var responseBody = await response.stream.bytesToString();

      if (response.statusCode == 200) {
        setState(() {
          _isLoading = false;
        });
        var data = jsonDecode(responseBody);
        SharedPreferences localStorage = await SharedPreferences.getInstance();
        localStorage.remove('user');
        localStorage.setString('user', json.encode(data['data']));
        // ignore: use_build_context_synchronously
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (context) => const Settings()),
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
      Response response =
          await post(Uri.parse("${dotenv.env['API_URL']}/api/edit"), body: {
        'name': name,
        'email': email,
        'address': address,
        'phone': phone,
        'state': state,
        'zipcode': zipcode,
        'country': country,
      }, headers: {
        'Authorization': "Bearer " + token
      });
      developer.log(response.statusCode.toString());
      if (response.statusCode == 200) {
        var data = jsonDecode(response.body.toString());
        SharedPreferences localStorage = await SharedPreferences.getInstance();
        localStorage.remove('user');
        localStorage.setString('user', json.encode(data['data']));
        // ignore: use_build_context_synchronously
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (context) => const Settings()),
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
    }
  }

  _loadUserData() async {
    SharedPreferences localStorage = await SharedPreferences.getInstance();
    var user = jsonDecode(localStorage.getString('user').toString());

    if (user != null) {
      setState(() {
        name = user['name'];
        email = user['email'];
        thumb = user['thumb'];
      });

      nameController.text = user['name'];
      emailController.text = user['email'];
      if (user['phone'] != null) {
        phoneController.text = user['phone'];
      }
      if (user['address'] != null) {
        addressController.text = user['address'];
      }
      if (user['state'] != null) {
        stateController.text = user['state'];
      }
      if (user['zipcode'] != null) {
        zipcodeController.text = user['zipcode'];
      }
      if (user['country'] != null) {
        countryController.text = user['country'];
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      resizeToAvoidBottomInset: false,
      // appBar: buildAppBar(context),
      body: Stack(
        children: [
          if (_isLoading) FullScreenLoader(),
          ListView(
            physics: const BouncingScrollPhysics(),
            children: [
              const AppBarLelangin(),
              image != null
                  ? Center(
                      child: Stack(
                        children: [
                          ClipOval(
                            child: Material(
                              color: Colors.transparent,
                              child: Image.file(
                                image!,
                                fit: BoxFit.cover,
                                width: 128,
                                height: 128,
                              ),
                            ),
                          ),
                          Positioned(
                            bottom: 0,
                            right: 4,
                            child: ClipOval(
                              child: Container(
                                padding: const EdgeInsets.all(8),
                                color: Theme.of(context).colorScheme.primary,
                                child: const Icon(
                                  Icons.edit,
                                  color: Colors.white,
                                  size: 20,
                                ),
                              ),
                            ),
                          ),
                        ],
                      ),
                    )
                  : ProfileWidget(
                      imagePath: thumb,
                      onClicked: () async {
                        setState(() {
                          isEdit = !isEdit;
                        });
                      },
                    ),
              const SizedBox(height: 24),
              buildName(user),
              const SizedBox(height: 24),

              // const SizedBox(height: 24),
              // const SizedBox(height: 48),
              // buildAbout(user),
              if (isEdit) buildEdit(user),

              // const SizedBox(height: 5),
              Container(
                padding: const EdgeInsets.all(10),
                child: ElevatedButton(
                  style: ElevatedButton.styleFrom(
                    minimumSize: const Size.fromHeight(50),
                    primary:
                        const Color.fromARGB(255, 236, 23, 33), // background
                    onPrimary: Colors.white, // foreground
                  ),
                  onPressed: () {
                    logout();
                  },
                  child: const Text('Logout'),
                ),
              ),
            ],
          ),
        ],
      ),
      bottomNavigationBar: BottomBarLelangin(
        active: 3,
      ),
    );
  }

  Widget buildName(User user) => Column(
        children: [
          Text(
            name,
            style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 24),
          ),
          const SizedBox(height: 4),
          Text(
            email,
            style: const TextStyle(color: Colors.grey),
          ),
        ],
      );

  Future getImage() async {
    final ImagePicker _picker = ImagePicker();
    final XFile? imagePicked =
        await _picker.pickImage(source: ImageSource.gallery);
    image = File(imagePicked!.path);
    setState(() {});
  }

  Widget buildEdit(User user) => Column(
        children: [
          Padding(
            padding: const EdgeInsets.all(10),
            child: ElevatedButton(
                style: ElevatedButton.styleFrom(
                  minimumSize: const Size.fromHeight(50),
                  primary: const Color(0xFF696cff), // background
                  onPrimary: Colors.white, // foreground
                ),
                onPressed: () async {
                  await getImage();
                },
                child: const Text('Change Image')),
          ),
          Container(
            padding: const EdgeInsets.all(10),
            child: TextField(
              controller: nameController,
              decoration: const InputDecoration(
                border: OutlineInputBorder(),
                labelText: 'Name',
              ),
            ),
          ),
          const SizedBox(height: 4),
          Row(
            children: [
              Flexible(
                child: Padding(
                  padding: const EdgeInsets.all(10),
                  child: TextField(
                    controller: emailController,
                    decoration: const InputDecoration(
                      border: OutlineInputBorder(),
                      labelText: 'E-Mail',
                    ),
                  ),
                ),
              ),
              Flexible(
                child: Padding(
                  padding: const EdgeInsets.all(10),
                  child: TextField(
                    controller: phoneController,
                    decoration: const InputDecoration(
                      border: OutlineInputBorder(),
                      labelText: 'Phone Number',
                    ),
                  ),
                ),
              ),
            ],
          ),
          const SizedBox(height: 4),
          Row(
            children: [
              Flexible(
                child: Padding(
                  padding: const EdgeInsets.all(10),
                  child: TextField(
                    controller: addressController,
                    decoration: const InputDecoration(
                      border: OutlineInputBorder(),
                      labelText: 'Address',
                    ),
                  ),
                ),
              ),
              Flexible(
                child: Padding(
                  padding: const EdgeInsets.all(10),
                  child: TextField(
                    controller: stateController,
                    decoration: const InputDecoration(
                      border: OutlineInputBorder(),
                      labelText: 'State',
                    ),
                  ),
                ),
              ),
            ],
          ),
          const SizedBox(height: 4),
          Row(
            children: [
              Flexible(
                child: Padding(
                  padding: const EdgeInsets.all(10),
                  child: TextField(
                    controller: zipcodeController,
                    decoration: const InputDecoration(
                      border: OutlineInputBorder(),
                      labelText: 'Zip Code',
                    ),
                  ),
                ),
              ),
              Flexible(
                child: Padding(
                  padding: const EdgeInsets.all(10),
                  child: TextField(
                    controller: countryController,
                    decoration: const InputDecoration(
                      border: OutlineInputBorder(),
                      labelText: 'Country',
                    ),
                  ),
                ),
              ),
            ],
          ),
          Container(
            padding: const EdgeInsets.all(10),
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
                edit(
                    nameController.text,
                    emailController.text,
                    addressController.text,
                    phoneController.text,
                    stateController.text,
                    zipcodeController.text,
                    countryController.text);
              },
              child: const Text('Save Changes'),
            ),
          ),
        ],
      );

  Widget buildAbout(User user) => Container(
        padding: const EdgeInsets.symmetric(horizontal: 48),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'About',
              style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 16),
            Text(
              user.about,
              style: const TextStyle(fontSize: 16, height: 1.4),
            ),
          ],
        ),
      );

  void logout() async {
    SharedPreferences localStorage = await SharedPreferences.getInstance();
    localStorage.remove('user');
    localStorage.remove('token');
    // ignore: use_build_context_synchronously
    Provider.of<AuthProvider>(context, listen: false).logout();
    // ignore: use_build_context_synchronously
    Navigator.pushAndRemoveUntil(
      context,
      MaterialPageRoute(builder: (BuildContext context) => const Login()),
      ModalRoute.withName('/login'),
    );
  }
}

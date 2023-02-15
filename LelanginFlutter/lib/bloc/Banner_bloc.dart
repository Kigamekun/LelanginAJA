import 'package:lelanginaja/model/BannerLelangin.dart';
import 'dart:async';
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:shared_preferences/shared_preferences.dart';

Future<List<BannerLelangin>>? fetchBanner() async {
  SharedPreferences localStorage = await SharedPreferences.getInstance();
  var token = jsonDecode(localStorage.getString('token').toString());

  final response = await http.get(
    Uri.parse(dotenv.env['API_URL'].toString() + "/api/banner"),
    headers: {
      "Content-Type": "application/json",
      'Authorization': 'Bearer ' + token
    },
  );

  if (response.statusCode == 200) {
    // If the server did return a 200 OK response,
    // then parse the JSON.
    var responseJson = jsonDecode(response.body);
    return (responseJson['data'] as List)
        .map((p) => BannerLelangin.fromJson(p))
        .toList();
  } else {
    // If the server did not return a 200 OK response,
    // then throw an exception.
    throw Exception('Failed to load Banner');
  }
}

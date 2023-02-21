import 'package:flutter/material.dart';

class AuthProvider with ChangeNotifier {
  bool _isAuthenticated = false;

  bool get isAuthenticated => _isAuthenticated;

  Future<void> login() async {
    // Your authentication logic goes here
    // If authentication succeeds, set the token and update isAuthenticated

    _isAuthenticated = true;
    notifyListeners();
  }

  Future<void> logout() async {
    // Your logout logic goes here
    // Clear the token and update isAuthenticated

    _isAuthenticated = false;
    notifyListeners();
  }
}

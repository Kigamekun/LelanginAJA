import 'package:flutter/material.dart';
import 'package:lelanginaja/widget/appbarlelangin.dart';
import 'package:webview_flutter/webview_flutter.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';

import 'dart:developer' as developer;
import 'package:lelanginaja/ui/history.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:http/http.dart';
import 'dart:convert';

class Payment extends StatefulWidget {
  final String id;

  const Payment({Key? key, required this.id}) : super(key: key);

  @override
  State<Payment> createState() => _PaymentState();
}

class _PaymentState extends State<Payment> {
  bool isPayed = false;

  @override
  void initState() {
    super.initState();
  }

  late final webViewController = WebViewController()
    ..setJavaScriptMode(JavaScriptMode.unrestricted)
    ..setNavigationDelegate(
      NavigationDelegate(
        onProgress: (int progress) {
          // Update loading bar.
          developer.log('A');
        },
        onPageStarted: (String url) {
          developer.log('B');
        },
        onPageFinished: (String url) {},
        onWebResourceError: (WebResourceError error) {},
        onNavigationRequest: (NavigationRequest request) {
          if (request.url.startsWith(
              dotenv.env['API_URL'].toString() + '/pay-api-finish')) {
            Navigator.pushReplacement(
              context,
              new MaterialPageRoute(builder: (context) => Histories()),
            );
            return NavigationDecision.prevent;
          }
          return NavigationDecision.navigate;
        },
      ),
    )
    ..loadRequest(
        Uri.parse(dotenv.env['API_URL'].toString() + "/pay-api/" + widget.id));

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: Text('Payment Auction'),
        ),
        resizeToAvoidBottomInset: false,
        body: Container(
          padding: EdgeInsets.all(10),
          child: WebViewWidget(controller: webViewController),
        ));
  }
}

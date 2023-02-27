import 'package:flutter/material.dart';

class FullScreenLoader extends StatefulWidget {
  const FullScreenLoader({Key? key}) : super(key: key);

  @override
  // ignore: library_private_types_in_public_api
  _FullScreenLoaderState createState() => _FullScreenLoaderState();
}

class _FullScreenLoaderState extends State<FullScreenLoader> {
  late OverlayEntry _overlayEntry;

  @override
  void initState() {
    super.initState();
    _overlayEntry = OverlayEntry(
      builder: (BuildContext context) {
        return Container(
          color: Colors.black54,
          child: const Center(
            child: CircularProgressIndicator(),
          ),
        );
      },
    );
    WidgetsBinding.instance!.addPostFrameCallback((_) => _showOverlay());
  }

  void _showOverlay() {
    Overlay.of(context)!.insert(_overlayEntry);
  }

  void _hideOverlay() {
    _overlayEntry.remove();
  }

  @override
  Widget build(BuildContext context) {
    return Container(); // Return an empty container as this is just a loader
  }

  @override
  void dispose() {
    _hideOverlay();
    super.dispose();
  }
}
